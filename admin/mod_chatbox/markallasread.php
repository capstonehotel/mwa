<?php

$senderid=$_GET['id'];

$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);


$sql = "UPDATE livechat SET status='1' WHERE sender_id=$senderid";

if ($conn->query($sql) === TRUE) {
  echo "Successfully Read All";
  header("Location: index.php");
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();



?>