<?php

$senderid=$_GET['id'];

    // Database connection details
    $servername = "127.0.0.1";
    $username = "u510162695_hmsystemdb";
    $password = "1Hmsystemdb";
    $dbname = "u510162695_hmsystemdb";
    $dbport ="3306";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname, $dbport);

$sql = "UPDATE livechat SET status='1' WHERE sender_id=$senderid";

if ($conn->query($sql) === TRUE) {
  echo "Successfully Read All";
  header("Location: index.php");
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();



?>