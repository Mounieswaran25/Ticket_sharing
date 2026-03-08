<?php

$server = "localhost";
$username = "root";
$password = "";
$dbname = "ticket_sharing";

$conn = new mysqli($server, $username, $password, $dbname);

if(!$conn){
    die("connection failed: " . mysqli_connect_error());
}
 
?>