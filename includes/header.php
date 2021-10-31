<header>
<script type = "text/javascript" src="js/function.js"></script>  
  <div class="content w_1280 m_auto">
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
        <?php
          if (!$_COOKIE['uid']) { ?>
            <li><a href="#" class="button" onclick="showLogin()">Login</a></li>
          <?php } else { ?>
            <li><a href="orders.php" class="button" ><?php echo $_COOKIE['firstName']; ?></li>
          <?php } ?>
        <li><a href="#" class="button" onclick="showCart()">Cart</a></li>
      </ul>
    </nav>

    <div class="user_form shadow">
      <div class="login">
        <h3>LOG IN TO MY ACCOUNT</h3>
        <p>Enter your E-mail & Password</p>
        <form method="post" action="logindo.php" onsubmit="checkLoginForm()">
          <input class="input email" type="email" required name="email" placeholder="Email" Onchange="checkEmail(this.value)"  /><br /><br />
          <input class="input" type="password" required name="password" placeholder="Password" /><br /><br />
          <button class="btn_primary clear">Log In</button><br /><br />
        </form>
        <p>New Customer? <a href="#" onclick="showRegister()">Create an Account</a></p>
      </div>

      <div class="reg">
        <h3>CREATE MY ACCOUNT</h3>
        <p>Please fill in your information below</p>
        <form method="post" action="includes/register.php" onsubmit="checkRegForm()">
          <input id="firstName" class="input" required type="text" name="firstName" placeholder="First Name" /><br /><br />
          <input id="lastName" class="input" required type="text" name="lastName" placeholder="Last Name" /><br /><br />
          <input class="input email" type="email" name="email" placeholder="Email" Onchange="checkEmail(this.value)" /><br /><br />
          <input class="input" type="password" name="password" placeholder="Password" /><br /><br />
          <button class="btn_primary" type="submit" name="submit">Create Account</button><br /><br />
        </form>
        <p>Already have an account? <a href="#" onclick="showLogin()">Log in here</a></p>
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
    </div>
  
  </div>
</header>