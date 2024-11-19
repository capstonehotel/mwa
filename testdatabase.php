<?php
$servername = "127.0.0.1";
$username = "u510162695_hmsystemdb";
$password = "1Hmsystemdb";
$dbname = "u510162695_hmsystemdb";
$dbport ="3306";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $dbport);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM tblroom";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["ROOMID"] . "<br />";
  }
} else {
  echo "0 results";
}
$conn->close();
?>
