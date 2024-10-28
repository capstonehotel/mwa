<?php
require_once 'initialize.php';
$yourid = $_POST['yourid'];
$yourname = $_POST['yourname'];
$yourimage = $_POST['yourimage'];
$yourroomid = $_POST['yourroomid'];
$yourstarrate = $_POST['yourstarrate'];
$yourcomment = $_POST['yourcomment'];




$servername = "127.0.0.1";
$username = "u510162695_hmsystemdb";
$password = "1Hmsystemdb";
$dbname = "u510162695_hmsystemdb";
$dbport = "3306";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $dbport);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO star_ratings (user_id, user_name, user_image, room_id, rating, comment)
VALUES ('$yourid', '$yourname', '$yourimage', '$yourroomid', '$yourstarrate', '$yourcomment')";

if ($conn->query($sql) === TRUE) {
  echo "Successfully Rated this room";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>