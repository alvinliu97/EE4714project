

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="robots" content="noarchive">
  <link rel="stylesheet" href="css/css.css" />
  <title>Contact Us</title>
</head>
<?php
include 'includes/conn.php';
if ($_POST) {
  $query = "insert into message (topic,email,enquiry,create_at) values ('{$_POST['topic']}','{$_POST['email']}','{$_POST['enquiry']}',now())";
  $result = $conn->query($query);
  echo "<script type='text/javascript'>alert('We have received your enquiries.');window.location.href='index.php';</script>";
    $to = $_POST['email'];
    $subject ="Enquiries Recived!";
    $txt = "Dear Customer, \n
    We have received your enquiries regarding : ***.\n
    The support group will contact you within three days.\n
    Thanks for your patience.\n\n
    Best reagrds,\n
    Makeletronics";
    $text=str_replace("***",$_POST['topic'],$txt);
    $headers = "From: Makeletronic@service.com" ;

    mail($to,$subject,$text,$headers);

}
?>

<body>
  <?php include "includes/header.php"; ?>
  <div id="main" class="w_920 m_auto clear">

    <div id="contact">
      <div class="bread">
        Home > My Account > My Orders
      </div>

      <h2 class="t_center">Contact Us</h2>
      <div class="form m_top_30">
        <form method="post" action="">
          <h3 class="color_primary">Topic</h3>
          <input type="text" name="topic" class="input" required="required" style="width:100%" />
          <h3 class="color_primary">Your Email</h3>
          <input type="text" name="email" class="input" required="required" style="width:100%" />
          <h3 class="color_primary">Your Enquiry</h3>
          <textarea name="enquiry" class="input" required="required"></textarea>
          <br /><br />
          <button class="btn btn_primary" style="width:100%">Send</button>
        </form>
        <div class="clear"></div>
      </div>

      <div class="clear"></div>
    </div>
  </div>

  <?php include "includes/footer.php"; ?>

</body>

</html>