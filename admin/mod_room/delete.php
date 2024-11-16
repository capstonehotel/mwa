<?php
require_once("../../includes/initialize.php");

if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    $id = (int)$_GET['id']; // Ensure $id is an integer for safety

    if ($id > 0) {
        // Perform deletion from tblreservation
        $sql = "DELETE FROM tblreservation WHERE ROOMID = $id";
        if ($connection->query($sql) === TRUE) {
            // Perform deletion from tblroom
            $sql1 = "DELETE FROM tblroom WHERE ROOMID = $id";
            if ($connection->query($sql1) === TRUE) {
                // Redirect to list page after deletion
                header("Location: index.php?delete=success");
                exit();
            } else {
                // Redirect to list page with error
                header("Location: index.php?delete=error");
                exit();
            }
        } else {
            // Redirect to list page with error
            header("Location: index.php?delete=error");
            exit();
        }
    }
}
?>