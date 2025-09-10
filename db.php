<?php
$host = "localhost"; 
$user = "root";   // apna MySQL username daaliye
$pass = "";       // agar password hai to yahan daaliye
$db   = "elitestate";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
