<?php
if ($conn->connect_error) {
    include_once('./php/error.php');
}

include_once('./php/countryarray.php');

$country_options = '';
foreach ($countries as $country) {
    $country_options .= '<option value=\"' . $country . '\">' . $country . '</option>';
}

echo '  <script type="text/javascript">
                var country_options = "' . $country_options . '";
            </script>';

if (isset($_POST["user_action"])) {
    if ($_POST["user_action"] == "register") {
        $name = trim($_POST["name"]);
        $address = trim($_POST["address"]);
        $phone = trim($_POST["phone"]);
        $country = trim($_POST["country"]);
        $gender = ucfirst(trim($_POST["gender"]));
        $birthday = trim($_POST["birthday"]);

        $shouldProcessFurther = true;
        preg_match('/^([a-zA-Z ]){2,30}$/', $name, $matches_name);
        preg_match('/\+?(\d-?){8,16}/', $phone, $matches_phone);

        //Validate name, address, phone, country
        if (
            empty($name) || empty($address) || empty($country) || empty($phone)
            || empty($matches_name) || empty($matches_phone) || !in_array($country, $countries)
        ) {
            $shouldProcessFurther = false;
        }

        $email = trim($_POST["email"]);
        $password = $_POST["password"];
        $password_verify = $_POST["password--verify"];

        preg_match('/^[\w-_\.]+@[\w_-]+$/', $email, $matches_email);

        //Validate email
        if (empty($matches_email)) {
            $shouldProcessFurther = false;
        }

        //Validate password
        if ($password != $password_verify) {
            $shouldProcessFurther = false;
        }

        if ($shouldProcessFurther) {
            $query = "START TRANSACTION;";
            $conn->query($query);

            $query = "INSERT INTO customers (fullName, address, country, phone";

            $counternsert_gender = false;
            if ($gender[0] == 'M' || $gender[0] == 'W') {
                $query .= ', gender';
                $counternsert_gender = true;
            }

            $counternsert_birthday = false;
            if (!empty($birthday)) {
                if (empty($matches_birthday)) {
                    $shouldProcessFurther = false;
                }

                $query .= ', birthday';
                $counternsert_birthday = true;
            }

            $query .= ') VALUES ("' . $name . '","' . $address . '","' . $country . '","' . $phone;
            if ($counternsert_gender) {
                $query .= '","' . $gender[0];
            }

            if ($counternsert_birthday) {
                $query .= '","' . $birthday;
            }

            $query .= '");';

            $result;
            if ($shouldProcessFurther) {
                $result = $conn->query($query);
            }

            if (!$result || $conn->affected_rows != 1) {
                //Unable to insert into customers table
                $shouldProcessFurther = false;
            }

            $customer_id = $conn->insert_id;

            if ($shouldProcessFurther) {
                $md5password = md5($password);
                $query = 'INSERT INTO accounts (customersID, email, password, role) VALUES (' . $customer_id . ',"' . $email . '","' . $md5password . '","USER");';
                $result = $conn->query($query);
                if (!$result || $conn->affected_rows != 1) {
                    //Unable to insert into accounts table
                    $shouldProcessFurther = false;
                }
            }

            if ($shouldProcessFurther) {
                //Passed all checks
                $query = 'COMMIT;';
                $conn->query($query);

                //Auto login
                $_SESSION["username"] = $name;
                $_SESSION["email"] = $email;
                $_SESSION["role"] = "USER";

                //Send email to notify success registration
                $msg = "We have received your application for membership at vapors. We hope you enjoy your stay.\n\n*** This is an automatically generated email, please do not reply ***";
                $msg = wordwrap($msg, 70);
                mail($email, "Registration at vapors Successful", $msg);
            } else {
                $query = 'ROLLBACK;';
                $conn->query($query);
                include_once('./php/error.php');
            }
        }
    } else if ($_POST["user_action"] == "login") {
        if (isset($_POST["email"]) && isset($_POST["password"])) {
            $email = trim($_POST["email"]);
            $query = 'SELECT c.fullName, c.id FROM customers AS c, accounts AS a WHERE c.id = a.customersID AND a.email ="' . $email . '";';
            $result = $conn->query($query);
            $countersvalid = true;

            if (!$result || $result->num_rows != 1) {
            } else {
                $row = $result->fetch_assoc();
                $name = $row["fullName"];
                $customer_id = $row["id"];
                $result->free();

                $password = $_POST["password"];
                $md5password = md5($password);

                $query = 'SELECT a.role FROM accounts AS a WHERE a.email="' . $email . '" AND password="' . $md5password . '";';
                $result = $conn->query($query);
                $num_rows = $result->num_rows;
                if (!$result || $num_rows != 1) {

                } else {
                    $row = $result->fetch_assoc();
                    $_SESSION["username"] = $name;
                    $_SESSION["email"] = $email;
                    $_SESSION["role"] = $row["role"];
                }
                $result->free();
            }
            unset($_SESSION["cart"]);
        }
    } else if ($_POST["user_action"] == "logout") {
        unset($_SESSION["username"]);
        unset($_SESSION["email"]);
        unset($_SESSION["role"]);
        unset($_SESSION["cart"]);
    }
}

echo '<nav class="nav">
            <div class="nav--secondary">
                <div class="container">
                    <div class="row">
                        <div class="twelve column" >
                            <div class="row nav__submenu">
                                <a href="./contact.php" class="button submenu__button">Contact</a>
                                <a href="./support.php" class="button submenu__button">Support</a>';
if (isset($_SESSION["username"])) {
    echo '<a href="info.php" class="button submenu__button"><strong>Welcome, ' .
        $_SESSION["username"] .
        '</strong></a>
             <form name="form-signout" method="post"><input type="hidden" name="user_action" value="logout"><span class="button submenu__button" id="submenu__button--logout" onclick="document.forms[\'form-signout\'].submit();"><strong>Sign Out</strong></span></form>';
} else {
    echo '<span class="button submenu__button" id="submenu__button--register"><strong>Register</strong></span>
              <span class="button submenu__button" id="submenu__button--login"><strong>Login</strong></span>';
}
?>

</div>
</div>
</div>
</div>
</div>
<div class="nav--primary">
    <div class="container">
        <div class="row">
            <div class="twelve column">
                <div class="row nav__menu">
                    <a href="./index.php" class="nav__logo"><img src="./images/logo.png" width="7.5rem"></a>
                    <a href="./shop.php?gender[]=M" id="menu__button--men" class="button menu__button">Men</a>
                    <a href="./shop.php?gender[]=W" id="menu__button--women" class="button menu__button">Women</a>
                    <form class="menu__search">
                        <input type="text" class="input--text search__input u-flex-1" placeholder="Nike MAX 2020">
                        <button type="submit" class="button button--secondary search__button">
                            <div class="icon">
                                Search
                            </div>
                        </button>
                    </form>
                    <a href="./cart.php" class="button menu__button">
                        Shopping cart
                        <div class="badge badge--empty button__badge">
                            <?php
                            $cart_size = sizeof($_SESSION["cart"]);
                            echo $cart_size;
                            ?>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</nav>