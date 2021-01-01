<?php
date_default_timezone_set('Africa/Lusaka');

$server = "localhost";
$username = "root";
$password = "";
$dbname = "tutorial";

// Create connection
try{
  $conn = new PDO("mysql:host=$server;dbname=$dbname","$username","$password");
  $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);    // set the PDO error mode to exception
}catch(PDOException $e){
  die('Unable to connect with the database '. $e->getMessage());
}
