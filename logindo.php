<?php
ob_start();
include 'includes/conn.php';
$query = "select * from user where email='{$_POST['email']}' && password='{$_POST['password']}'";
$result = $conn->query($query);
$rows = $result->fetch_assoc();

if (!$rows) {
    echo "<script type='text/javascript'>alert('error');history.back();</script>";
} else {
    setcookie("firstName", $rows['firstName']);
    setcookie("lastName", $rows['lastName']);
    setcookie("uid", $rows['id']);
    echo "<script type='text/javascript'>alert('Congratulations on your successful login!');window.location.href='index.php';</script>";
}
