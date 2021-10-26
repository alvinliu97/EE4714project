<!DOCTYPE html>
<html lang="en-GB">
<?php include './php/head.php'; ?>
<body>

	<?php
        session_start();

    
        $conn = new mysqli("localhost", "f32ee", "f32ee", "f32ee");

        if ($conn->connect_error) {
        
            include_once ('./php/error.php');
            exit();
        }

        include './php/navbar.php';
        include_once ('./php/countryarray.php');

        if (isset($_SESSION["username"]) && !empty(trim($_SESSION["username"]))&& isset($_SESSION["email"]) && !empty(trim($_SESSION["email"]))) {
            //Update profile here
            $passwordupdated = false;
            $detailsupdated = false;
            if (isset($_POST["update"])) {
                $address = trim($_POST["address"]);
                $phone = trim($_POST["phone"]);
                $country = trim($_POST["country"]);
                $gender = ucfirst(trim($_POST["gender"]));
                $birthday = trim($_POST["birthday"]);

                $oldPassword = $_POST["password--old"];
                $password = $_POST["password"];

                $shouldProcessFurther = true;
                preg_match('/\+?(\d-?){8,16}/', $phone, $matches_phone);

                //Validate address, phone, country
                if (empty($address) || empty($country) || empty($phone) || empty($matches_phone) || !in_array($country, $countries)) {
                    $shouldProcessFurther = false;
                }

                $query = 'SELECT customersID FROM accounts WHERE email = "' . $_SESSION["email"] . '";';
                $result = $conn->query($query);
                $num_rows = $result->num_rows;
                if (!$result || $num_rows != 1) {
                    include_once ('./php/error.php');
                    exit();
                } else {
                    $row = $result->fetch_assoc();
                    $customer_id = $row["customersID"];
                    $result->free();

                    $query = "START TRANSACTION;";
                    $conn->query($query);

                    if (isset($oldPassword) && isset($password) && !empty($oldPassword) && !empty($password)) {
                        $password_verify = $_POST["password--verify"];

                        //Validate password
                        if ($password != $password_verify) {
                            $shouldProcessFurther = false;
                        }

                        $md5password = md5($password);
                        if ($shouldProcessFurther) {
                            $query = 'UPDATE accounts SET password = "' . $md5password . '" WHERE email = "' . $_SESSION["email"] .'";';
                            $result = $conn->query($query);
                            if (!$result) {
                                $shouldProcessFurther = false;
                            } else if ($conn->affected_rows == 1) {
                                $passwordupdated = true;
                            }
                        }
                    }


                    if ($shouldProcessFurther) {
                        $query = 'UPDATE customers SET address = "' . $address . '" , phone = "' . $phone .'" , country = "' . $country . '"';

                        if ($gender[0] == 'M' || $gender[0] == 'W') {
                            $query .= ', gender = "' . $gender[0] . '"';
                        }

                        if (!empty($birthday)) {
                            $query .= ', birthday = "' . $birthday . '"';
                        }

                        $query .= ' WHERE fullName = "' . $_SESSION["username"] . '" AND id = '. $customer_id . ';';
                        $result = $conn->query($query);
                        if (!$result)  {
                            $shouldProcessFurther = false;
                        } else if ($conn->affected_rows == 1) {
                            $detailsupdated = true;
                        }
                    }

                    if ($shouldProcessFurther && ($passwordupdated || $detailsupdated)) {
                        //Passed all checks
                        $query = 'COMMIT;';
                        $conn->query($query);
                    } else {
                        $query = 'ROLLBACK;';
                        $conn->query($query);
                    }

                }
            }

            $query = 'SELECT gender, address, phone, birthday, country FROM accounts AS a, customers AS c WHERE c.id = a.customersID AND a.email="' . $_SESSION["email"] . '" AND c.fullName="' . $_SESSION["username"] . '";';
            $result = $conn->query($query);
            $num_rows = $result->num_rows;
            if ($num_rows != 1) {
                //Email not found or name not correct
                include_once ('./php/error.php');
            } else {
                $row = $result->fetch_assoc();
                $gender = $row["gender"];
                echo '  <section class="profile">
                            <div class="container">
                                <div class="row">
                                    <div class="two column"></div>
                                    <div class="two column">
                                        <aside>
                                            <div class="profile__name">
                                                <h4 class="header">' . $_SESSION["username"] . '</h4>
                                            </div>
                                            <a href="./info.php" class="button button--large profile__menu profile__menu--active">
                                                My Profile
                                            </a>
                                            <a href="./history.php" class="button button--large profile__menu">
                                                Past Orders
                                            </a>' ;

                if ($_SESSION["role"] == "ADMN") {
                    echo '                  <a href="#" class="button button--large profile__menu">
                                                Add Product
                                            </a>';
                }

                echo '                  </aside>
                                    </div>
                                    <div class="six column">
                                        <form method="post" id="profile__edit" onsubmit="return true;">
                                            <input type="hidden" name="update">
                                            <h2 class="header u-m-large--bottom">My Profile</h2>
                                            <div class="u-flex">
                                               <div class="u-m-medium--bottom">
                                                    <label for="email" class="label--top">
                                                        Email
                                                    </label>
                                                    <input type="text" name="email" id="email" class="input--text u-fill" placeholder="name@email.com" value="' . $_SESSION["email"] . '" disabled>
                                               </div>
                                               <div class="u-m-medium--bottom">
                                                    <label for="address" class="label--required label--top">
                                                        Address
                                                    </label>
                                                    <input type="text" name="address" id="address" class="input--text u-fill" placeholder="Delivery address" value="' . $row["address"] . '" required>
                                               </div>
                                               <div class="u-m-medium--bottom">
                                                    <label for="gender" class="label--top">
                                                        Gender
                                                    </label>
                                                    <label for="gender--men" class="label--radio u-inline-block u-m-medium--right">
                                                        <input type="radio" name="gender" value="Men" id="gender--men" class="input--radio"' . (empty($gender) ? '' : ($gender == "M" ? " checked disabled" : " disabled")) . '>
                    
                                                        Men
                                                    </label>
                                                    <label for="gender--women" class="label--radio u-inline-block">
                                                        <input type="radio" name="gender" value="Women" id="gender--women" class="input--radio"' . (empty($gender) ? '' : ($gender == "W" ? " checked disabled" : " disabled")) . '>
                                                        Women
                                                    </label>
                                               </div>
                                               <div class="u-m-medium--bottom">
                                                    <label for="phone" class="label--required label--top">
                                                        Phone No.
                                                    </label>
                                                    <input type="text" name="phone" id="phone" class="input--text u-fill" placeholder="Phone number" value="' . $row["phone"] . '" required>
                                               </div>
                                               <div class="u-m-medium--bottom">
                                                    <label for="country" class="label--required label--top">
                                                        Country
                                                    </label>
                                                    <select name="country" id="country" class="input--text u-fill"> ';
                foreach ($countries as $country) {
                    echo '                              <option' . ($country == $row["country"] ? ' selected' : '') . ' value="' . $country . '">' . $country . '</option>';
                }
                echo '                              </select>
                                               </div>
                                               <div class="u-m-medium--bottom">
                                                    <label for="birthday" class="label--top">
                                                        Birthday
                                                    </label>
                                                    <input type="text" name="birthday" id="birthday" class="input--date u-fill"' . (empty($row["birthday"]) ? '' : ' value="' . $row["birthday"] . '" disabled') . '>
                                               </div>
                                                <div class="u-m-large--bottom">
                                                    <button type="button" class="button button--tertiary u-m-medium--top" id="profile-change-password" onclick="toggleAccountProfile()">
                                                        Change Password
                                                    </button>
                                                     <div class="u-m-medium--bottom u-is-hidden" id="profile-oldpassword">
                                                        <label for="oldpassword" class="label--required label--top">
                                                            Old Password
                                                        </label>
                                                        <input type="password" name="password--old" id="oldpassword" class="input--text u-fill" placeholder="Enter old password" onblur="validateOldPassword()">
                                                    </div>
                                                    <div class="u-m-medium--bottom u-is-hidden" id="profile-password">
                                                        <label for="password" class="label--required label--top">
                                                            Password
                                                        </label>
                                                        <input type="password" name="password" id="password" class="input--text u-fill" placeholder="Enter new password" onblur="validatePassword()">
                                                    </div>
                                                    <div class="u-m-medium--bottom u-is-hidden"  id="profile-verifypassword">
                                                        <label for="password--verify" class="label--required label--top">
                                                            Verify Password
                                                        </label>
                                                        <input type="password" name="password--verify" id="password--verify" class="input--text u-fill" placeholder="Re-enter password" onblur="verifyPassword()">
                                                    </div>
                                                </div>
                                                <div>
                                                    <button type="submit" class="button button--primary button--large">
                                                        Update Profile
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="two column"></div>
                                </div>
                            </div>
                        </section>';
            }
            $result->free();
        } else {
            //Not logged in
        }

        $conn->close();
        include './php/footer.php';
    ?>
	<script type="text/javascript" src='./js/script.js'></script>
</body>
</html>