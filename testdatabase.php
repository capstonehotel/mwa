<?php
require_once ("initialize.php");
// $servername = "127.0.0.1";
// $username = "u510162695_hmsystemdb";
// $password = "1Hmsystemdb";
// $dbname = "u510162695_hmsystemdb";
// $dbport = "3306";

// Create connection
// $conn = new mysqli($servername, $username, $password, $dbname, $dbport);
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to count rows
// $sql = "SELECT COUNT(*) AS total_rows FROM livechat";
// $result = $connection->query($sql);

// if ($result->num_rows > 0) {
//     $row = $result->fetch_assoc();
//     echo "Total number of rows in the livechat table: " . $row["total_rows"];
// } else {
//     echo "Unable to count rows. The table may be empty.";
// }

// $sql = "SELECT * FROM tblguest";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     echo "<table border='1'>";
//     echo "<tr><th>ID</th><th>GUESTID</th><th>session_token</th><th>last_activity</th></tr>";
//     while ($row = $result->fetch_assoc()) {
//         echo "<tr>";
//         echo "<td>" . htmlspecialchars($row["GUESTID"]) . "</td>";
//         echo "<td>" . htmlspecialchars($row["session_token"]) . "</td>";
//         echo "<td>" . htmlspecialchars($row["last_activity"]) . "</td>";
       
//         echo "</tr>";
//     }
//     echo "</table>";
// } else {
//     echo "No records found.";
// }
$sql = "TRUNCATE TABLE sessions";


// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "Table 'truncated' created successfully!";
} else {
    echo "Error creating table: " . $conn->error;
}
// SQL to drop the user_devices table
// $sql = "DROP TABLE IF EXISTS user_devices";

// if ($conn->query($sql) === TRUE) {
//     echo "Table 'user_devices' deleted successfully!";
// } else {
//     echo "Error deleting table: " . $conn->error;
// }


// SQL query to fetch all rows from the sessions table
$sql = "SELECT * FROM sessions";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Start the HTML table
    echo "<table border='1' cellpadding='10' cellspacing='0'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>User</th>";
    echo "<th>Device</th>";
    echo "<th>Location</th>";
    echo "<th>IP Address</th>";
    echo "<th>Date</th>";
    echo "<th>Action</th>";
    echo "</tr>";
    echo "</thead>";

    // Fetch and display the rows
    echo "<tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['user']) . "</td>";
        echo "<td>" . htmlspecialchars($row['device']) . "</td>";
        echo "<td>" . htmlspecialchars($row['location']) . "</td>";
        echo "<td>" . htmlspecialchars($row['ip_address']) . "</td>";
        echo "<td>" . htmlspecialchars($row['date_logged']) . "</td>"; // Adjust based on your actual column name
        echo "<td><a href='delete_session.php?id=" . $row['id'] . "'>Delete</a></td>"; // Optional: link to delete session
        echo "</tr>";
    }
    echo "</tbody>";

    // End the HTML table
    echo "</table>";
} else {
    echo "No sessions found.";
}

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
