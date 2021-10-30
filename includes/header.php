<header>
<script type = "text/javascript" src="js/function.js"></script>  
    <div class="content w_920 m_auto">
        <div class="logo">
            <a href="index.php">
                <img src="imgs/logo.png" />
            </a>
        </div>
        <div class="menu">
            <ul>
                <li><a href="products.php"><img src="imgs/search.png" alt="Search" style="padding-top:25px;width:30px;height:30px;"></a></li>
                <li><a href="index.php#faq" ><img src="imgs/faq.png" alt="FAQ" style="padding-top:25px;width:30px;height:30px;"></a></a></li>
                <?php
                if (!$_COOKIE['uid']) { ?>
                    <!-- <li><a href="#" onclick="showLogin()">LOGIN</a></li> -->
                    <li><a href="#" onclick="showLogin()"><img src="imgs/user.png" alt="LOGIN" style="padding-top:25px;width:30px;height:30px;"></a></a></li>
                <?php } else { ?>
                    <li><a href="orders.php" style="color:orange;" ><?php echo $_COOKIE['firstName']; ?></a></li>
                <?php } ?>
                <li><a href="#" onclick="showCart()"><img src="imgs/cart.png" alt="CART" style="padding-top:25px;width:30px;height:30px;"></a></a></li>
            </ul>
        </div>

        <div class="user_form shadow">
            <div class="login">
                <h3>LOG IN TO MY ACCOUNT</h3>
                <p>Enter your E-mail & Password</p>
                <form method="post" action="logindo.php" onsubmit="checkLoginForm()">
                    <input class="input email" type="email" required name="email" placeholder="Email" /><br /><br />
                    <input class="input" type="password" required name="password" placeholder="Password" /><br /><br />
                    <button class="btn_primary clear">Log In</button><br /><br />
                </form>
                <p>New Customer? <a href="#" onclick="showRegister()">Create an Account</a></p>
            </div>

            <div class="reg">
                <h3>CREATE MY ACCOUNT</h3>
                <p>Please fill in your information below</p>
                <form method="post" action="regdo.php" onsubmit="checkRegForm()">
                    <input id="firstName" class="input" required type="text" name="firstName" placeholder="First Name"  /><br /><br />
                    <input id="lastName" class="input" required type="text" name="lastName" placeholder="Last Name" /><br /><br />
                    <input class="input email" type="email" name="email" placeholder="Email" /><br /><br />
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
            <form method="post" action="payment.php">
                <div class="lists">

                    <?php
                    $count = 0;
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
                            <p><strong><?php echo $deatil['brandName']; ?><strong></p>
                            <p class="title"><?php echo $deatil['title']; ?></p>
                            <hr>
                            <p ><input class="input" onKeyDown="return false" name="num[]" type="number" min=1 max="<?php echo $deatil['stock']; ?>" value="<?php echo $vo['num']; ?>" /> 
                           <span style="float:right;">$<?php echo $deatil['price']; ?></span>
                            </p>
                            
                        </div>
                        
                    <?php } ?>
                </div>
                <div class="total">
                    <p style="text-align:right;"><span>Total:</span> <span>$<?php echo $count; ?></span></p>  
                    <button type="button" class="a_btn btn btn_def" onclick="window.location.href='addcart.php?act=clear'">clear Cart</button>
                    <button class="a_btn btn btn_primary" >Checkout</button>
                </div>
                </form>
        </div>
    
    </div>
</header>