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

    include './php/navbar.php';
    echo '<section id="cart" class="cart">
        <form method="POST" action="checkout.php">
            <div class="container">
                <div class="twelve column">
                    <h2 class="header u-m-medium--bottom">Shopping cart</h2>
                    <table class="u-fill">
                        <tr class="table__row">
                            <th>Image</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th class="u-align--right">Subtotal</th>
                            <th></th>
                        </tr>';

    if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
        echo '<tr class="table__row"><td colspan="7">You have no items in your cart.</td></tr>';
        echo '  </table>';
    } else {
        //Build an array of product IDs in the cart to facilitate single query only
        $product_ids = array();
        $product_colors = array();
        $product_sizes = array();
        foreach ($_SESSION["cart"] as $cart_item) {
            $product_id = $cart_item->id;
            array_push($product_ids, $product_id);
            $product_color = $cart_item->color;
            array_push($product_colors, $product_color);
            $product_size = $cart_item->size;
            array_push($product_sizes, $product_size);
        }
        $field = '(';
        $first_item = true;
        foreach (array_unique($product_ids) as $product_id) {
            if ($first_item) {
                $field .= $product_id;
                $first_item = false;
            } else {
                $field .= ',' . $product_id;
            }
        }
        $field .= ')';

        $query = 'SELECT p.id, p.name, p.price, p.discount, p.description FROM products AS p WHERE p.id IN ' . $field . ';';
        $result = $conn->query($query);
        $product_names = array();
        $product_prices = array();
        $product_description = array();
        $total = 0;
        if ($result) {
            $num_rows = $result->num_rows;
            if ($num_rows > 0) {
                for ($counter = 0; $counter < $num_rows; $counter++) {
                    $row = $result->fetch_assoc();
                    $counterd = $row["id"];
                    $name = $row["name"];
                    $description = $row["description"];
                    $price_after_discount = (1 - $row["discount"] / (float)100) * $row["price"];
                    $product_names[$counterd] = $name;
                    $product_prices[$counterd] = $price_after_discount;
                    $product_description[$counterd] = $description;
                }
                //Get stocks
                $stock_condition = '(productsID = ' . $product_ids[0] . ' AND color ="' . $product_colors[0] . '" AND size="' . $product_sizes[0] . '")';
                for ($counter = 1; $counter < sizeof($product_ids); $counter++) {
                    $stock_condition .= ' OR (productsID = ' . $product_ids[$counter] . ' AND color ="' . $product_colors[$counter] . '" AND size="' . $product_sizes[$counter] . '")';
                }

                $query = 'SELECT productsID, color, size, stock FROM inventory AS i WHERE ' . $stock_condition . ';';

                $result->free();
                $result = $conn->query($query);

                if ($result) {
                    $num_rows = $result->num_rows;
                    if ($num_rows > 0) {
                        $inventory_array = array();
                        for ($counter = 0; $counter < $num_rows; $counter++) {
                            $row = $result->fetch_assoc();
                            $color = lcfirst($row["color"]);
                            $counterd = $row["productsID"];
                            $size = $row["size"];
                            $stock = $row["stock"];
                            $inventory_array[$counterd][$color][$size] = $stock;
                        }
                        $result->free();

                        $counterndex = 0;
                        $something_oos = false;

                        foreach ($_SESSION["cart"] as $cart_item) {
                            $counterd = $cart_item->id;
                            $color = $cart_item->color;
                            $quantity = $cart_item->quantity;
                            $size = $cart_item->size;
                            $prices_per_item = $product_prices[$counterd];
                            $stock = $inventory_array[$counterd][$color][$size];

                            //Saturate if quantity > stock, also removes checkout button if stock is empty
                            if ($quantity > $stock) {
                                $quantity = $stock;
                                $_SESSION["cart"][$counterndex]->quantity = $stock;
                            }

                            if ($stock < 1) {
                                $something_oos = true;
                            }
                            $subtotal = $prices_per_item * $quantity;
                            $total += $subtotal;

                            echo '<tr class="table__row">
                                                      <td>';
                            echo '<img src="./images/' . $counterd . '_' . $color . '.jpg" class="cart__thumbnail">';
                            echo '    </td>
                            <td>' . ucfirst($color) . '</td>
                            <td>' . $size . '</td>
                            <td>' . $product_names[$counterd] . '</td>
                            <td id="' . $counterd . '_' . $color . '_' . $size . '_price-single">$' . number_format($prices_per_item, 2) . '</td>
                            <td>' . $quantity . '</td>';
                            echo '<td class="u-align--right"><strong>$<span class="price-subtotal" id="' . $counterd . '_' . $color . '_' . $size . '_price-subtotal">' .
                                number_format($subtotal, 2) . '
                                                      </span></strong></td>
                                                  </tr>';
                            $counterndex += 1;
                        }
                    }
                } else {
                    //Unable to query database for stocks
                    include_once('./php/error.php');
                    exit();
                }
            }
        } else {
            //Unable to query database for products information
            include_once('./php/error.php');
            exit();
        }
        echo '  </table>
                                        <div class="cart__review">
                                            <div class="cart__subtotal">
                                                <h4 class="header"><strong>Total $<span id="total-price">' . number_format($total, 2) . '</span></strong></h4>
                                            </div>';
        if (!$something_oos) {
            echo '      <button type="submit" class="button button--primary button--large">
                                                    Proceed to checkout
                                                </button>';
        }
        echo '  </div>';
    }
    $conn->close();
    ?>
    </div>
    </div>
    </form>
    </section>
    <?php include './php/footer.php' ?>
    <?php //session_destroy() 
    ?>
    <script type="text/javascript" src='./js/script.js'></script>
</body>

</html>