<?php
require_once("../../includes/initialize.php");
// load config file first 




if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id']; // Ensure $id is an integer for safety

    if ($id > 0) {
        // Perform deletion from tblreservation
        $sql = "DELETE FROM tblreservation WHERE ROOMID = $id";
        if ($connection->query($sql) === TRUE) {
            // Perform deletion from tblroom
            $sql1 = "DELETE FROM tblroom WHERE ROOMID = $id";
            if ($connection->query($sql1) === TRUE) {
                // Return success response
                echo json_encode(['success' => true]);
                exit;
            } else {
                // Handle SQL error
                http_response_code(500);
                echo json_encode(['error' => 'Failed to delete room.']);
                exit;
            }
        } else {
            // Handle SQL error
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete reservation.']);
            exit;
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid ID.']);
        exit;
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request.']);
    exit;
}
?>
