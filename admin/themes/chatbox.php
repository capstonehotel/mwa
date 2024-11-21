



<?php

$user_id = $_GET['user_id'];
    $name = $_GET['name'];
    $message = $_GET['message'];

    // Database connection details
    $servername = "127.0.0.1";
    $username = "u510162695_hmsystemdb";
    $password = "1Hmsystemdb";
    $dbname = "u510162695_hmsystemdb";
    $dbport ="3306";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO livechat (sender_id, name, message, status)
VALUES ('$user_id', '$name', '$message', '0')";

if (empty($message)) {
  echo "error";
} else {
  $conn->query($sql);
  echo "success";
}

// if ($conn->query($sql) === TRUE) {
//   echo "Sent";
// } else {
//   echo "Error: " . $sql . "<br>" . $conn->error;
// }

$conn->close();
?>