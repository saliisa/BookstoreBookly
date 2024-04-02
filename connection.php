<?php 
  $server = "localhost";
  $user = "root";
  $password = "";
  $database= "bookly";
  $conn = new mysqli($server, $user, $password, $database);
  if ($conn->connect_error) {
    echo 'No Connection';
    die("Connecting to database failed: " . $conn->connect_error);
  }
?>