<!DOCTYPE html>
<html lang="en-GB">
<?php include './php/head.php'; ?>


<body>
    <?php
    include './php/cart-item.php';
    session_start();

    $conn = new mysqli("localhost", "f32ee", "f32ee", "f32ee");

    if ($conn->connect_error) {
        exit();
    }

    $outofstock = array();
    $emailregistered = true;
    $isSuccessTransaction = true;

    if (isset($_POST["buy"])) {
        $items = $_POST["items"];

        $is_logged_in = true;
        if (!isset($_SESSION["username"]) || empty(trim($_SESSION["username"])) || !isset($_SESSION["email"]) || empty(trim($_SESSION["email"]))) {
            $is_logged_in = false;
        }

        $shouldProcessFurther = true;
        $customer_id = -1;


        $query = "START TRANSACTION;";
        $conn->query($query);

        if ($is_logged_in) {
            $query = 'SELECT c.id FROM customers AS c, accounts AS a WHERE c.id = a.customersID AND c.fullName="' . $_SESSION["username"] . '" AND 
                a.email = "' . $_SESSION["email"] . '";';
            $result = $conn->query($query);
            $num_rows = $result->num_rows;
            if ($num_rows != 1) {
                //Email not found or name not correct
                $shouldProcessFurther = false;
            } else {
                $row = $result->fetch_assoc();
                $customer_id = $row["id"];
            }
            $result->free();
        } else {
            //Not logged in, add record into customers (and accounts if needed)
            $name = trim($_POST["name"]);
            $address = trim($_POST["address"]);
            $phone = trim($_POST["phone"]);
            $country = trim($_POST["country"]);
            $create_account = $_POST["create-account"];
            $gender = ucfirst(trim($_POST["gender"]));
            $birthday = trim($_POST["birthday"]);


            if ($shouldProcessFurther) {
                $query = "INSERT INTO customers (fullName, address, country, phone";

                $insert_gender = false;
                if ($gender[0] == 'M' || $gender[0] == 'W') {
                    $query .= ', gender';
                    $insert_gender = true;
                }

                $insert_birthday = false;
                if (!empty($birthday)) {
                    $query .= ', birthday';
                    $insert_birthday = true;
                }

                $query .= ') VALUES ("' . $name . '","' . $address . '","' . $country . '","' . $phone;
                if ($insert_gender) {
                    $query .= '","' . $gender[0];
                }

                if ($insert_birthday) {
                    $query .= '","' . $birthday;
                }

                $query .= '");';
                $result;
                if ($shouldProcessFurther) {
                    $result = $conn->query($query);
                }
                if (!$result || $conn->affected_rows != 1) {
                    $shouldProcessFurther = false;
                }
                $customer_id = $conn->insert_id;
            }
        }

        //Validate items format
        $product_ids = array();
        $product_color = array();
        $product_size = array();
        $product_qty = array();
        $unique_product_ids = array();
        if ($shouldProcessFurther) {
            foreach ($items as $item) {
                preg_match('/^(\d+)_([a-z]+)_(\d+)_(\d+)/', $item, $matches_item);
                if (empty($matches_item)) {
                    $shouldProcessFurther = false;
                    break;
                } else {
                    $id = $matches_item[1];
                    array_push($product_ids, $id);
                    array_push($product_color, ucfirst($matches_item[2]));
                    array_push($product_size, $matches_item[3]);
                    array_push($product_qty, $matches_item[4]);
                }
            }
            $unique_product_ids = array_unique($product_ids);
        }

        //Get product prices
        $product_prices = array();
        if ($shouldProcessFurther) {
            $field = '(';
            $first_item = true;
            foreach ($unique_product_ids as $id) {
                if ($first_item) {
                    $field .= $id;
                    $first_item = false;
                } else {
                    $field .= ',' . $id;
                }
            }
            $field .= ')';

            $query = 'SELECT p.id, p.price, p.discount FROM products AS p WHERE p.id IN ' . $field . ';';
            $result = $conn->query($query);

            if ($result) {
                $num_rows = $result->num_rows;
                //Expect to get same number of records as there are unique IDs. Otherwise some IDs are invalid.
                if ($num_rows == sizeof($unique_product_ids)) {
                    for ($counter = 0; $counter < $num_rows; $counter++) {
                        $row = $result->fetch_assoc();
                        $id = $row["id"];
                        $price_after_discount = (1 - $row["discount"] / (float)100) * $row["price"];

                        $product_prices[$id] = $price_after_discount;
                    }
                } else {
                    $shouldProcessFurther = false;
                }
                $result->free();
            } else {
                //Unable to query for price
                $shouldProcessFurther = false;
            }
        }

        $shipping = 'standard';

        if ($shouldProcessFurther) {
            $query = 'INSERT INTO orders (customersID, ordersDate, shipping) VALUES(' . $customer_id . ', NOW(),"' . $shipping . '");';
            $result = $conn->query($query);
            if (!$result || $conn->affected_rows != 1) {
                //Unable to insert into orders table
                $shouldProcessFurther = false;
            }
        }

        $order_id = $conn->insert_id;

        if ($shouldProcessFurther) {
            for ($counter = 0; $counter < sizeof($product_ids); $counter++) {
                $id = $product_ids[$counter];

                //Get inventory id
                $query = 'SELECT i.id FROM inventory AS i WHERE i.productsID = ' . $id . ' AND i.color = "' . $product_color[$counter] .
                    '" AND i.size = "' . $product_size[$counter] . '";';
                $result = $conn->query($query);
                if (!$result || $result->num_rows != 1) {
                    $shouldProcessFurther = false;
                    break;
                }
                $row = $result->fetch_assoc();
                $inventory_id = $row["id"];
                $result->free();

                //Populate orders_inventory table
                $query = 'INSERT INTO orders_inventory (inventoryID, ordersID, pricePerItem, quantity) VALUES (' . $inventory_id . ',' . $order_id .
                    ',' . $product_prices[$id] . ',' . $product_qty[$counter] . ');';
                $result = $conn->query($query);
                if (!$result || $conn->affected_rows != 1) {

                    $shouldProcessFurther = false;
                    break;
                }

                $query = 'UPDATE inventory SET stock = stock - ' . $product_qty[$counter] . ' WHERE id=' . $inventory_id . ' AND stock >= ' . $product_qty[$counter]
                    . ';';
                $result = $conn->query($query);
                if (!$result) {
                    //Unable to update inventory table
                    $shouldProcessFurther = false;
                    break;
                } else if ($conn->affected_rows != 1) {
                    //Stock is exhausted, check for all 0 stocks to show in form
                    $shouldProcessFurther = false;
                    array_push($outofstock, $id . '_' . lcfirst($product_color[$counter]) . '_' . $product_size[$counter]);
                }
            }
        }

        if ($shouldProcessFurther) {
            //Passed all checks
            $query = 'COMMIT;';
            $conn->query($query);

            if (isset($_SESSION["email"])) {
                //Send email to notify success orders
                $msg = "We have received your transaction at vapors. Thank you for shopping with us.\r\n\r\n*** This is an automatically generated email, please do not reply ***";
                $msg = wordwrap($msg, 70);
                mail("f32ee@localhost", "Transaction at vapors Successful", $msg);
            }

            $msg = "A customer (ID:" . $customer_id . ") has made a transaction (ID:" . $order_id . ").\r\n\r\n*** This is an automatically generated email, please do not reply ***";
            $msg = wordwrap($msg, 70);
            mail("f32ee@localhost", "New Transaction at vapors", $msg);

            //Remove cart items that are purchased
            array_splice($_SESSION["cart"], 0, sizeof($items));

            $isSuccessTransaction = true;
        } else {
            $query = 'ROLLBACK;';
            $conn->query($query);
            if (!$emailregistered && empty($outofstock)) {
                include_once('./php/error.php');
                exit();
            }
        }
    }

    if (!isset($_POST["buy"]) || $emailregistered || !empty($outofstock) || $isSuccessTransaction) {
        //Before checkout form is submitted
        include_once('./php/navbar.php');
        $empty_cart = false;
        if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
            $empty_cart = true;
        } else {
            //Build an array of product IDs in the cart to facilitate single query only
            $product_ids = array();
            foreach ($_SESSION["cart"] as $cart_item) {
                $product_id = $cart_item->id;
                if (!in_array($product_id, $product_ids)) {
                    array_push($product_ids, $product_id);
                }
            }

            $field = '(';
            $first_item = true;
            foreach ($product_ids as $product_id) {
                if ($first_item) {
                    $field .= $product_id;
                    $first_item = false;
                } else {
                    $field .= ',' . $product_id;
                }
            }
            $field .= ')';

            $query = 'SELECT p.id, p.name, p.price, p.discount FROM products AS p WHERE p.id IN ' . $field . ';';
            $result = $conn->query($query);

            $product_names = array();
            $product_prices = array();
            if ($result) {
                $num_rows = $result->num_rows;
                if ($num_rows > 0) {
                    for ($counter = 0; $counter < $num_rows; $counter++) {
                        $row = $result->fetch_assoc();
                        $id = $row["id"];
                        $name = $row["name"];
                        $price_after_discount = (1 - $row["discount"] / (float)100) * $row["price"];
                        $product_prices[$id] = $price_after_discount;
                        $product_names[$id] = $name;
                    }
                }
                $result->free();
            } else {
                //Unable to query database for products price
                include_once('./php/error.php');
                exit();
            }
        }

        $is_logged_in = true;
        $row;
        if (!isset($_SESSION["username"]) || empty(trim($_SESSION["username"])) || !isset($_SESSION["email"]) || empty(trim($_SESSION["email"]))) {
            $is_logged_in = false;
        } else {
            $query = 'SELECT c.address, c.gender, c.phone, c.country, c.birthday FROM customers AS c, accounts AS a WHERE c.id = a.customersID  AND a.email="' . $_SESSION["email"] . '" AND c.fullName="' . $_SESSION["username"] . '";';
            $result = $conn->query($query);
            if (!$result) {
                //Failed to query
                $is_logged_in = false;
            }
            if ($result->num_rows != 1) {
                //echo query;
                $is_logged_in = false;

            } else {
                $row = $result->fetch_assoc();
            }
            $result->free();
        }
    }

    echo '
        <section class="checkout">
            <div class="container">
                <form id="checkout" method="post" action="checkout.php" onsubmit="return validateCheckout()">
                    <input type="hidden" name="buy">'; ?>


    <div class="row">
        <div class="four column">
            <section class="stepper">
                <div class="stepper__header">
                    <div class="stepper__step-name">
                        <h3>Billing Address</h3>
                    </div>
                </div>
                <div class="stepper__content">
                    <table class="u-fill">
                        <tbody class="checkout__section">
                            <tr class="checkout__row">
                                <td>
                                    <label class="label--required">Full Name</label>
                                </td>
                                <td>
                                    <span class="input">
                                        <input type="text" name="name" id="name" class="input--text u-fill" onblur=validateName() placeholder="Your full name" required>
                                    </span>
                                </td>
                            </tr>
                            <tr class="checkout__row">
                                <td>
                                    <label class="label--required">Address</label>
                                </td>
                                <td>
                                    <span class="input">
                                        <input type="text" name="address" id="address" class="input--text u-fill" placeholder="Delivery address" required>
                                    </span>
                                </td>
                            </tr>
                            <tr class="checkout__row">
                                <td>
                                    <label>Gender</label>
                                </td>
                                <td>
                                    <span class="input">
                                        <label for="gender--men" class="label--radio u-inline-block u-m-medium--right">
                                            <input type="radio" name="gender" value="men" id="gender--men" class="input--radio">
                                            Women
                                        </label>
                                        <label for="gender--women" class="label--radio u-inline-block">
                                            <input type="radio" name="gender" value="women" id="gender--women" class="input--radio">
                                            Men
                                        </label>
                                    </span>
                                </td>
                            </tr>
                            <tr class="checkout__row" class="label--required">
                                <td>
                                    <label class="label--required">Phone No.</label>
                                </td>
                                <td>
                                    <span class="input">
                                        <input type="text" name="phone" id="phone" class="input--text u-fill" onblur = validatePhone() placeholder="Phone number (without country code)" required>
                                    </span>
                                </td>
                            </tr>

                            <?php
                            echo '
                            <tr class="checkout__row">
								<td>
									<label class="label--required">Country</label>
								</td>
								<td>
									<span class="input">
										<select name="country" id="country" class="input--text u-fill">' .
                                $country_options .
                                '</select>
									</span>
								</td>
                            </tr>'
                            ?>
                            <tr class="checkout__row">
                                <td>
                                    <label>Birthday</label>
                                </td>
                                <td>
                                    <span class="input">
                                        <input type="text" name="birthday" id="birthday" class="input--date u-fill" onblur=validateBirthday() placeholder="e.g. 2000-12-09">
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <div class="four column">
            <section class="stepper">
                <div class="stepper__header">
                    <div class="stepper__step-name">
                        <h3>Shipping</h3>
                    </div>
                </div>
                <div>
                    <label for="shipping--standard" class="label--radio u-inline-block u-m-medium--bottom">
                        <input type="radio" name="shipping" value="standard" id="shipping--standard" class="input--radio" checked>
                        <span><strong>Home Delivery</strong></span>
                        <br>
                        <span>$6.00, 3-5 working days</span>
                    </label>
                </div>
            </section>
            <section class="stepper">
                <div class="stepper__header">
                    <div class="stepper__step-name">
                        <h3>Payment Information</h3>
                    </div>
                </div>
                <table class="u-fill">
                    <tbody class="checkout__section">
                        <tr class="checkout__row" class="label--required">
                            <td>
                                <label class="label--required">Card Type</label>
                            </td>
                            <td>
                                <span class="input">
                                    <select class="select u-fill">
                                        <option value="mastercard">MasterCard</option>
                                        <option value="visa">VISA</option>
                                    </select>
                                </span>
                            </td>
                        </tr>
                        <tr class="checkout__row">
                            <td>
                                <label class="label--required">Card Number</label>
                            </td>
                            <td>
                                <span class="input">
                                    <input type="text" name="card-number" id="card-number" class="input--text u-fill" required>
                                </span>
                            </td>
                        </tr>
                        <tr class="checkout__row">
                            <td>
                                <label class="label--required">Expiry</label>
                            </td>
                            <td>
                                <span class="input">
                                    <div id="payment__expiry" class="payment__expiry">
                                        <select class="select u-m-medium--right u-flex-2">
                                            <option value="January" selected="selected">Jan</option>
                                            <option value="February">Feb</option>
                                            <option value="March">Mar</option>
                                            <option value="April">Apr</option>
                                            <option value="May">May</option>
                                            <option value="June">Jun</option>
                                            <option value="July">Jul</option>
                                            <option value="August">Aug</option>
                                            <option value="September">Sep</option>
                                            <option value="October">Oct</option>
                                            <option value="November">Nov</option>
                                            <option value="December">Dec</option>
                                        </select>
                                        <select class="select u-flex-1">
                                            <option value="2020" selected="selected">2020</option>
                                            <option value="2021">2021</option>
                                            <option value="2021">2022</option>
                                            <option value="2023">2023</option>
                                        </select>
                                    </div>
                                </span>
                            </td>
                        </tr>
                        <tr class="checkout__row">
                            <td>
                                <label class="label--required">CVV</label>
                            </td>
                            <td>
                                <input type="text" name="vcc" id="vcc" class="input--text" required>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </div>
        <div class="four column">
            <section class="stepper">
                <div class="stepper__header">
                    <div class="stepper__step-name">
                        <h3>Order Confirmation</h3>
                    </div>
                </div>
                <table class="u-fill">
                    <tr class="table__row">
                        <th>Item</th>
                        <th class="u-align--center">Quantity</th>
                        <th class="u-align--right">Subtotal</th>
                    </tr>
                    <?php

            if (!$empty_cart) {
                $price_sum = 0;
                foreach ($_SESSION["cart"] as $cart_item) {
                    $id = $cart_item->id;
                    $name = $product_names[$id];
                    $color = $cart_item->color;
                    $size = $cart_item->size;
                    $qty = $cart_item->quantity;
                    $prices_per_item = $product_prices[$id];
                    $price_subtotal = $qty * $prices_per_item;
                    $price_sum += $price_subtotal;
                    echo '<tr class="table__row">
                                                <td>' . $name . ' (' . ucfirst($color) . ',' . $size . ')</td>
                                                <td class="u-align--center">' . $qty . '</td>
                                                <td class="u-align--right">$' . number_format($price_subtotal, 2) . '</td>
                                            </tr>
                                            ';
                    echo '<input type="hidden" name="items[]" value="' . $id . '_' . $color . '_' . $size . '_' . $qty . '">
                                            ';
                }
                 echo'
                <tr class="table__row">
                    <td colspan="2" class="u-align--left">
                        <div>Subtotal</div>
                        <div>Shipping</div>
                        <div>
                            <h3 class="header u-m-medium--top">Total</h3>
                        </div>
                    </td>
                    <td class="u-align--right">
                        <div>'?><?php echo '$' . number_format($price_sum, 2); ?><?php echo'</div>
                        <div>$6.00</div>
                        <div>
                            <h3 class="header u-m-medium--top">'?><?php echo '$' . number_format($price_sum + 6, 2); ?><?php echo'</h3>
                        </div>
                    </td>
                </tr>
                </table>'?>
                
                <?php  echo'  <div class="cart__order">
                    <button type="submit" class="button button--primary button--large">
                        Place Order
                    </button>
                </div>
            </section>'?>
                <?php
            } else{
                echo '                          <tr class="table__row">';
                if ($isSuccessTransaction){
                    echo '<td colspan="3" style="color:green; font-size: 160%; font-weight: bold">Items successfuly purchased</td></table>';
                }
            }
            ?>
            </section>
        </div>
    </div>
    </form>
    </div>
    </section><?php
                $conn->close();
                include './php/footer.php' ?>
    <script type="text/javascript" src='./js/script.js'></script>
</body>

</html>
