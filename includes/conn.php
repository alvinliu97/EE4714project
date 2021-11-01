<?php
ob_start();
session_start();
error_reporting(0);
@$conn = new mysqli('localhost','f32ee','f32ee','f32ee');
// @ to ignore error message display //
if ($conn->connect_error){
	echo "Database is not online"; 
	exit;
	// above 2 statments same as die() //
	}
	// else
	// echo "Congratulations...  MySql is working..";

if (!$conn->select_db ("f32ee"))
	exit("<p>Unable to locate the f32ee database</p>");
?>	
