<?php
require_once("../../initialize.php");

// Check if the necessary POST variables are set
if (isset($_POST['user_id'], $_POST['user_name'], $_POST['message'])) {
    $user_id = $_POST['user_id'];
    $name = $_POST['user_name'];
    $message = $_POST['message'];

    // Check if message is empty
    if (empty($message)) {
        echo "Error: Message cannot be empty.";
        exit;
    }

    // Create connection
    $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare and execute SQL query
    $sql = "INSERT INTO livechat (sender_id, user_name, message, status) VALUES (?, ?, ?, '0')";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("iss", $user_id, $name, $message);

        // Execute the query
        if ($stmt->execute()) {
            echo "Sent";
        } else {
            echo "Error: Could not send message. " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Error: Failed to prepare the SQL statement.";
    }

    // Close connection
    $conn->close();
} else {
    echo "Error: Missing required fields (user_id, user_name, or message).";
}
?>
