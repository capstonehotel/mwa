<?php
require_once("../../includes/initialize.php");

if (isset($_GET['confirm']) && $_GET['confirm'] == 'true' && isset($_GET['id'])) {
    $id = $connection->real_escape_string($_GET['id']);
    if ($id > 0) {
        $sql = "DELETE FROM tblreservation WHERE CONFIRMATIONCODE = '$id'";
        $sql2 = "DELETE FROM tblpayment WHERE CONFIRMATIONCODE = '$id'";
        
        if ($connection->query($sql) === TRUE && $connection->query($sql2) === TRUE) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error deleting record: ' . $connection->error]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

$connection->close();
?>
