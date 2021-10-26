<header>
    <div class="content w_920 m_auto">
        <div class="logo">
            <a href="index.php">
                <img src="imgs/logo.png" />
                <span>
                    <p><strong>MAKELECTRONIC</strong></p>
                    SINGAPORE
                </span>
            </a>
        </div>
        <div class="menu">
            <ul>
                <li><a href="products.php">SEARCH</a></li>
                <li><a href="#">FAQ</a></li>
                <?php
                if (!$_COOKIE['uid']) { ?>
                    <li><a href="#" onclick="showLogin()">LOGIN</a></li>
                <?php } else { ?>
                    <li><a href="orders.php"><?php echo $_COOKIE['firstName']; ?></a></li>
                <?php } ?>
                <li><a href="#" onclick="showCart()">CART</a></li>
            </ul>
        </div>

        <div class="user_form shadow">
            <div class="login">
                <h3>LOG IN TO MY ACCOUNT</h3>
                <p>Enter your E-mail & Password</p>
                <form method="post" action="logindo.php">
                    <input class="input" type="text" name="email" placeholder="Email" /><br /><br />
                    <input class="input" type="password" name="password" placeholder="Password" /><br /><br />
                    <button class="btn_primary clear">Log In</button><br /><br />
                </form>
                <p>New Customer? <a href="#" onclick="showRegister()">Create an Account</a></p>
            </div>

            <div class="reg">
                <h3>CREATE MY ACCOUNT</h3>
                <p>Please fill in your information below</p>
                <form method="post" action="regdo.php">
                    <input class="input" type="text" name="firstName" placeholder="First Name" /><br /><br />
                    <input class="input" type="text" name="lastName" placeholder="Last Name" /><br /><br />
                    <input class="input" type="text" name="email" placeholder="Email" /><br /><br />
                    <input class="input" type="password" name="password" placeholder="Password" /><br /><br />
                    <button class="btn_primary">Log In</button><br /><br />
                </form>
                <p>Already have an account? <a href="#" onclick="showLogin()">Log in here</a></p>
            </div>

            <div class="success">
                <h3>ACCOUNT SUCCESSFULLY CREATED!</h3>
                <p>
                    <img src="imgs/success.png" /><br /><br />
                </p><button class="btn_primary">Log In</button><br /><br />
            </div>

        </div>

        <div class="cart">
            <h3>Cart (<?php echo count($_SESSION['cart']); ?>)</h3>
            <div class="lists">

                <?php
                foreach ($_SESSION['cart'] as $vo) {

                    $query = "select p.*,b.title as brandName from product p left join brand b on b.id = p.band_id where p.id = {$vo['id']}";
                    $result = $conn->query($query);
                    $deatil = $result->fetch_assoc();
                    $thumb = json_decode($deatil['image']);
                    $count = $count + $vo['num'] * $deatil['price'];
                ?>
                    <div class="item">
                        <div class="img">
                            <img src="imgs/<?php echo $thumb[0]; ?>" />
                        </div>
                        <p><?php echo $deatil['brandName']; ?></p>
                        <p class="title"><?php echo $deatil['title']; ?></p>
                        <p><input class="input" type="number" value="<?php echo $vo['num']; ?>" /> <span>$<?php echo $deatil['price']; ?></span>
                        </p>
                    </div>
                <?php } ?>
            </div>
            <div class="total">
                <p><span>Total:</span> <span>$<?php echo $count; ?></span></p>
                <a class="a_btn btn btn_primary" href="payment.php">Log in to Checkout</a><br />
                <a class="a_btn btn btn_def" href="addcart.php?act=clear">Guest Checkout</a>
            </div>
        </div>
        <?php

        ?>
        <script>
            function showLogin() {
                var item = document.getElementsByClassName('user_form')[0].style.display = 'block';

                var item = document.getElementsByClassName('login')[0].style.display = 'block';
                var item = document.getElementsByClassName('reg')[0].style.display = 'none';
            }

            function showRegister() {
                var item = document.getElementsByClassName('login')[0].style.display = 'none';
                var item = document.getElementsByClassName('reg')[0].style.display = 'block';
            }

            function showCart() {
                var item = document.getElementsByClassName('cart')[0].style.display = 'block';
                var item = document.getElementsByClassName('login')[0].style.display = 'none';
                var item = document.getElementsByClassName('reg')[0].style.display = 'none';
            }
        </script>
    </div>
</header>