<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include 'includes/conn.php';
$email = $_POST['email'];
$query = "select username from user where email = '{$email}'";
$result = $conn->query($query);
if ($result) {
    echo "<script type='text/javascript'>alert('The user name has already been registered');history.back();</script>";
};
$query = "insert into user (firstName,lastName,email,password,create_at) values ('{$_POST['firstName']}','{$_POST['lastName']}','{$_POST['email']}','{$_POST['password']}',now())";
$result = $conn->query($query);
echo "<script type='text/javascript'>alert('ACCOUNT SUCCESSFULLY CREATED!');window.location.href='index.php';</script>";
?>