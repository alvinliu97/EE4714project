
<?php include "includes/conn.php"; ?>
<script type = "text/javascript" src="js/function.js"></script> 
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="robots" content="noarchive">
  <link rel="stylesheet" href="css/css.css" />
  <title>Payment</title>
</head>

<body>
  
  <?php include "includes/header.php"; ?>
  <?php

  $query = "select * from user where id = {$_COOKIE['uid']}";
  $result = $conn->query($query);
  $user = mysqli_fetch_assoc($result);
  ?>
  <div id="main" class="w_920 m_auto clear">

    <div id="payment">

      <h1 class="t_center">MAKELECTRONIC</h1>
      <h3 class="t_center">SINGAPORE</h3>

      <div class="left border">
        <form method="post" action="shopping.php" onsubmit="return checkForm()">
          <h3>Your Details</h3>
          <p class="">Contact Information</p>
          <input type="email" class="input w_100" required="required" name="c_email" value="<?php echo $user['email']; ?>" placeholder="Email" />

          <p>Shipping Address</p>
          <input type="text" class="input w_49" required="required" name="s_firstname" placeholder="First Name" value="<?php echo $user['firstName']; ?>" />
          <input type="text" class="input w_49" required="required" name="s_lastname" placeholder="Last Name" value="<?php echo $user['lastName']; ?>" />

          <input id="address" type="text" class="input w_100" required="required" name="s_address" placeholder="Address" />

          <input type="text" class="input w_100" required="required" name="s_apartment" placeholder="Apartment, suite, etc." />
          <input id="Postal" type="text" class="input w_100" required="required" name="s_post" placeholder="Postal Code" />

          <h3>Your Payment Info</h3>
          <p>Credit/Debit Card</p>

          <input id="email" type="email" class="input w_100" required="required" name="p_email" Onchange="checkEmail(this.value) placeholder="Email" />
          <input type="text" class="input w_49" required="required" name="p_firstname"  placeholder="First Name" />
          <input type="text" class="input w_49" required="required" name="p_lastname" placeholder="Last Name" />

          <input type="text" class="input w_100" required="required" name="p_card" placeholder="Card No." />
          <input type="date" class="input w_100" required="required" name="p_expiry" placeholder="Expiry" />

          <input type="text" class="input w_100" required="required" name="p_cvv" placeholder="CVV" />
          <input type="text" class="input w_100" required="required" name="p_promo" placeholder="Promo Code" />
          <br /><br />
          <button class="btn btn_primary w_49">Place Order</button>
          <button class="btn btn_def w_49">Return to cart</button>
        </form>

      </div>


      <div class="right border">
        <?php
        $count = 0;
        $i = 0;
        foreach ($_SESSION['cart'] as &$vo) {
          if ($_POST['num'][$i]) {
            $_SESSION['cart'][$i]['num'] = $_POST['num'][$i];
          }
          $query = "select p.*,b.title as brandName from product p left join brand b on b.id = p.band_id where p.id = {$vo['id']}";
          $result = $conn->query($query);
          $deatil = $result->fetch_assoc();
          $thumb = json_decode($deatil['image']);
          $count = $count + $vo['num'] * $deatil['price'];
          $i++;
        ?>
          <div class="item">
            <div class="img">
              <img src="imgs/<?php echo $thumb[0]; ?>" />
            </div>
            <p><span class="f_left"><?php echo $deatil['brandName']; ?></span></p>
            <p class="title"><span class="f_left"><?php echo $deatil['title']; ?> * <?php echo $vo['num']; ?></span></p>
            <p><span class="f_right"><input class="input" type="number" value="<?php echo $vo['num']; ?>" /></span> <span class="f_right">$<?php echo $vo['num'] * $deatil['price']; ?></span></p>
          </div>
        <?php } ?>
        <br /><br /><br />
        <hr class="clear" />
        <p><span class="f_left">Subtotal</span><span class="f_right">$<?php echo $count; ?></span></p>
        <hr class="clear" />
        <p><span class="f_left">Total</span><span class="f_right">$<?php echo $count; ?></span></p>

      </div>

      <div class="clear"></div>

    </div>
  </div>
   
  <?php include "includes/footer.php"; ?>
</body>

</html>