<?php //register.php
  // We check if the user has clicked the signup button
  if (isset($_POST['submit'])) {
  // Then we include the database connection
  include 'conn.php';
  // And we get the data from the signup form
  $first =$_POST['firstName'];
  $last =$_POST['lastName'];
  $email =$_POST['email'];
  $pwd =$_POST['password'];
  $pwd= md5($pwd);


  
  // Check if inputs are empty
  if (empty($first) || empty($last) || empty($email) || empty($pwd)) {
    header("Location: ../index.php?signup=empty");
    exit();
  }
  
  else {
    // Check if email already exists
    $emailQuery = "
    SELECT * from user
    WHERE email = '$email';
    ";
    $queryResult = $conn->query($emailQuery);
    if (mysqli_num_rows($queryResult) > 0) {
    echo "<script type='text/javascript'>alert('The email has already been registered');history.back();</script>";
    exit();
    };

    $query = "insert into user (firstName,lastName,email,password,create_at) values ('$first','$last','$email','$pwd',now())";
    $result = $conn->query($query);

    if (!$result) {
    echo "<script type='text/javascript'>alert('registration unsuccessful');window.location.href='../index.php';</script>";
    }
    else {
    echo "<script type='text/javascript'>alert('Registration was successful! Please login.');window.location.href='../index.php';</script>";
    }
  }
  }
?>