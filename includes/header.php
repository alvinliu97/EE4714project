<?php  // Intializing the cart in session global variables 
session_start();
if (!isset($_SESSION['cart'])){
	$_SESSION['cart'] = array();
} ?>

<header class="padding_top_30">
<script type = "text/javascript" src="js/function.js"></script>  
  <div class="content w_1280 mx_auto">
    <div class="logo">
      <a href="index.php">
        <img src = "imgs/logo.png" class="h_72" />
        <img src = "imgs/makelectronic.svg" class="padding_10" >
      </a>
    </div>
    <nav>
      <ul>
        <li><a href="products.php" class="button">Search</a></li>
        <li><a href="index.php#faq" class="button">FAQ</a></li>
        <li>
          <?php
            if (!$_COOKIE['uid']) { ?>
              <a href="#" class="button" onclick="showLogin()">Login</a>
            <?php } else { ?>
              <a href="orders.php" class="button" ><img src = "imgs/account.svg" class="nav_button_logo" ><?php $first = $_COOKIE['firstName'][0]; $last = $_COOKIE['lastName'][0]; echo $first . $last?></a>
            <?php } ?>
        </li>
        <li><a href="#" class="button" onclick="showCart()"><img src = "imgs/cart.svg" class="nav_button_logo" >Cart (<?php echo count($_SESSION['cart']); ?>)</a></li>
      </ul>
    </nav>

    <div class="user_form shadow">
      <div class="login">
        <form method="post" action="logindo.php" onsubmit="checkLoginForm()">
          <div class="form_header">
            <div class="login_title">
              Login to my account
            </div>
            <div class="login_subtitle">
              Enter your E-mail & password
            </div>
          </div>
          <div class="form_input_wrapper">
            <input class="form_field email" type="email" required name="email" placeholder="Email" onchange="checkEmail(this.value)"  />
          </div>
          <div class="form_input_wrapper">
            <input type="password" name="password" placeholder="Enter Password" class="form_field" required>
          </div>   
          <div> 
            <button type="submit">Log In</button>
          </div>
          <div class="form_footer">
            <div class="login_subtitle">
              New Customer? <br />
              <a href="#" class="dark-blue"onclick="showRegister()" >Create an Account</a>
            </div>
          </div>
        </form>
      </div>

      <div class="reg">
        <form method="post" action="includes/register.php" onsubmit="checkRegForm()">
          <div class="form_header">
            <div class="login_title">
              Create my account
            </div>
            <div class="login_subtitle">
              Please fill in your information below
            </div>
          </div>
          <div class="form_input_wrapper">
            <input class="form_field" id="firstName" required type="text" name="firstName" placeholder="First Name"  />
          </div>
          <div class="form_input_wrapper">
            <input class="form_field" id="lastName" required type="text" name="lastName" placeholder="Last Name" />
          </div>   
          <div class="form_input_wrapper">
            <input class="form_field email" type="email" name="email" placeholder="Enter Email" Onchange="checkEmail(this.value)"  />
          </div>
          <div class="form_input_wrapper">
            <input class="form_field" type="password" name="password" placeholder="Password" />
          </div> 
          <div> 
            <button type="submit" name="submit">Create Account</button>
          </div>
          <div class="form_footer">
            <div class="login_subtitle">
            Already have an account? <br />
              <a href="#" class="dark-blue"onclick="showLogin()" >Log in here</a>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="cart shadow">
      <?php if (count($_SESSION['cart']) > 0 ) { ?>
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
                <p ><input class="input" name="num[]" type="number" min=1 max="<?php echo $deatil['stock']; ?>" value="<?php echo $vo['num']; ?>" onchange="checkStock(this)" /> 
                 <span style="float:right;">$<?php echo $deatil['price']; ?></span>
                </p>
                
              </div>
              
            <?php } ?>
          </div>
          <div class="total">
            <p style="text-align:right;"><span>Total:</span> <span>$<?php echo $count; ?></span></p>  
            <button type="button" class="a_btn btn btn_def" onclick="window.location.href='addcart.php?act=clear'">clear Cart</button>
            <button class="a_btn btn btn_primary" <?php if ($count==0){ ?> onClick="alert('Nothing in Cart'); return false; " <?php   } ?>>Checkout</button>
            
          </div>
        </form>
      <?php } else { ?>
        <div class="cart_content cart_content_empty">
          <div class="cart_empty_state">
            <img src = "imgs/cart.svg" class="empty_logo">
            <div class="login_title">
              Your Cart is empty
            </div>
          </div>
          <a href="products.php">
            <button>Shop our products</button>
          </a>
        </div>
      <?php } ?>

    </div>
  
  </div>
</header>