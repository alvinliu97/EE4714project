<?php
ob_start();
include 'includes/conn.php';

$email = $_POST['email'];
$password = $_POST['password'];
$password = md5($password);

$query = "select * from user where email='$email' && password='$password'";
$result = $conn->query($query);
$rows = $result->fetch_assoc();

if (!$rows) {
  echo "<script type='text/javascript'>alert('Wrong email or password!');history.back();</script>";
} else {
  setcookie("firstName", $rows['firstName']);
  setcookie("lastName", $rows['lastName']);
  setcookie("uid", $rows['id']);
  echo "<script type='text/javascript'>alert('Successful login!');window.location.href='index.php';</script>";
}
