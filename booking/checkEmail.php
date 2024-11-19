<?php
session_start();
require_once("../includes/initialize.php"); // Include your database connection file

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT COUNT(*) FROM tblguest WHERE G_UNAME = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    // Return true if email exists, false otherwise
    echo json_encode($count > 0);
}
?>