<?php
//open session
include 'includes/conn.php';
session_start();
//check if logged in
if (empty($_COOKIE['uid'])) {
	echo "<script>alert('please Login First!');location.href='index.php';</script>";
	exit();
}

foreach ($_SESSION['cart'] as $vo) {
	$conn->query("update product set stock = stock - {$vo['num']} where id = {$vo['id']}");
}

$product = json_encode($_SESSION['cart']);

$sql = "insert into orders (c_email,s_firstname,s_lastname,s_address,s_apartment,s_post,p_email,p_firstname,p_lastname,p_card,p_expiry,p_cvv,p_promo,product,uid,create_at) 
values 
('{$_POST['c_email']}','{$_POST['s_firstname']}','{$_POST['s_lastname']}','{$_POST['s_address']}','{$_POST['s_apartment']}','{$_POST['s_post']}','{$_POST['p_email']}','{$_POST['p_firstname']}','{$_POST['p_lastname']}','{$_POST['p_card']}','{$_POST['p_expiry']}','{$_POST['p_cvv']}','{$_POST['p_promo']}','{$product}',{$_COOKIE['uid']},now())";
$result = $conn->query($sql);

  $to ="f32ee@localhost";
  $subject ="Order Recived!";

  $txt = "Dear Customer, \n
  We have received your order.\n
  You will receive your order in a few days.\n
  Meanwhile, check Your userprofile for your order details. \n
  Thanks for your patience.\n\n
  Best reagrds,\n
  Makeletronics";

  $headers = "From: Makeletronic@service.com" ;

  mail($to,$subject,$txt,$headers);
$_SESSION['cart']=[];
echo "<script>alert('success!');location.href='orders.php';</script>";

exit();
