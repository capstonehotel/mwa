<?php
require_once("../../includes/initialize.php");

header('Content-Type: application/json');

// Check if 'id' is set in the query string
if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    $id = $_GET['id'];
    // Attempt to delete the record from tblcontact table
    $sql = "DELETE FROM tblcontact WHERE CONTID = $id";

    if ($connection->query($sql) === TRUE) {
        // Deletion successful
        echo json_encode(['status' => 'success']);
    } else {
        // Deletion unsuccessful
        echo json_encode(['status' => 'error']);
    }
}

// Close the database connection
$connection->close();
?>
