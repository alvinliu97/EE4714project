<?php
ob_start();
session_start();
error_reporting(E_ALL);
$conn = new mysqli("127.0.0.1", "f32ee", "f32ee", "f32ee");

if (mysqli_connect_errno()){

    echo mysqli_connect_error();
}