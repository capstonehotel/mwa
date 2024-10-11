<?php
// Include your database connection file
include('../includes/initialize.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Make sure to use parameterized queries to prevent SQL injection
    $stmt = $connection->prepare("DELETE FROM tblreservation WHERE ROOMID = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $stmt->close();
        $stmt1 = $connection->prepare("DELETE FROM tblroom WHERE ROOMID = ?");
        $stmt1->bind_param("i", $id);
        if ($stmt1->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }
        $stmt1->close();
    } else {
        echo 'error';
    }
}
?>
