<?php
// Check if the necessary POST variables are set
if (isset($_GET['user_id']) && isset($_GET['name']) && isset($_GET['message'])) {
    $user_id = $_GET['user_id'];
    $name = $_GET['name'];
    $message = $_GET['message'];

    // // Database connection details
    // $servername = "127.0.0.1";
    // $username = "u510162695_hmsystemdb";
    // $password = "1Hmsystemdb";
    // $dbname = "u510162695_hmsystemdb";
    // $dbport ="3306";

    // // Create connection
    // $conn = new mysqli($servername, $username, $password, $dbname, $dbport);
    $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if message is empty
    if (empty($message)) {
        echo "error";
    } else {
        // Prepare and execute SQL query
        $sql = "INSERT INTO livechat (sender_id, name, message, status) VALUES (?, ?, ?, '0')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $user_id, $name, $message);

        if ($stmt->execute()) {
            echo "Sent";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();

}
?>
