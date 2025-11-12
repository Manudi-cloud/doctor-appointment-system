<?php

$server = "localhost";
$username = "root";
$password = "";
$dbname = "doc_appointment";

//connect to database

$con = mysqli_connect($server, $username, $password, $dbname );

//check the connection

if(!$con){
   die("Failed to connect to database: " .mysqli_connect_error());
} else{
   //echo "Connection successfull!";
}
?>
