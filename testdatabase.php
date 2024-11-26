<?php
require_once 'initialize.php';
// $servername = "127.0.0.1";
// $username = "u510162695_hmsystemdb";
// $password = "1Hmsystemdb";
// $dbname = "u510162695_hmsystemdb";
// $dbport = "3306";

// Create connection
// $conn = new mysqli($servername, $username, $password, $dbname, $dbport);
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to count rows
$sql = "SELECT COUNT(*) AS total_rows FROM livechat";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "Total number of rows in the livechat table: " . $row["total_rows"];
} else {
    echo "Unable to count rows. The table may be empty.";
}
// $sql = "SELECT * FROM livechat";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     echo "<table border='1'>";
//     echo "<tr><th>ID</th><th>Sender ID</th><th>Username</th><th>Message</th></tr>";
//     while ($row = $result->fetch_assoc()) {
//         echo "<tr>";
//         echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
//         echo "<td>" . htmlspecialchars($row["sender_id"]) . "</td>";
//         echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
//         echo "<td>" . htmlspecialchars($row["message"]) . "</td>";
//         echo "</tr>";
//     }
//     echo "</table>";
// } else {
//     echo "No records found.";
// }

 $conn->close();


// $servername = "127.0.0.1";
// $username = "u510162695_hmsystemdb";
// $password = "1Hmsystemdb";
// $dbname = "u510162695_hmsystemdb";
// $dbport ="3306";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname, $dbport);

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);
// // Check connection
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }

// $sql = "SELECT * FROM livechat";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     while($row = $result->fetch_assoc()) {
//         echo "ID " . $row["id"] . "<br />";
//         echo "sender_id " . $row["sender_id"] . "<br />";
//         echo "user_name" . $row["username"] . "<br />";
//         echo "message" . $row["message"] . "<br />";
//     }
// } else {
//     echo "No tables found.";
// }

// $conn->close();
// $sql = "SELECT * FROM notifications";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//   // output data of each row
//   while($row = $result->fetch_assoc()) {
//     echo "GUESTID " . $row["GUESTID"] . "<br />";
//   }
// } else {
//   echo "0 results";
// }
// $conn->close();
?>
