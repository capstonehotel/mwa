<?php

$yourid = $_POST['yourid'];
$yourname = $_POST['yourname'];
$yourimage = $_POST['yourimage'];
$yourroomid = $_POST['yourroomid'];
$yourstarrate = $_POST['yourstarrate'];
$yourcomment = $_POST['yourcomment'];




$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hmsystemdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
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