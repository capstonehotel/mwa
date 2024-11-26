<?php
require_once ("../../includes/initialize.php");
// Check if the necessary POST variables are set
if (isset($_POST['user_id']) && isset($_POST['user_name']) && isset($_POST['message'])) {
    $user_id = $_POST['user_id'];
    $name = $_POST['user_name'];
    $message = $_POST['message'];

   

    // Create connection
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
        $sql = "INSERT INTO livechat (sender_id, user_name, message, status) VALUES (?, ?, ?, '0')";
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
