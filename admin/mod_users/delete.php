<?php
require_once("../../includes/initialize.php");

header('Content-Type: application/json');

$response = array('success' => false);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Attempt to delete the record from tbluseraccount table
    $sql = "DELETE FROM tbluseraccount WHERE USERID = $id";
    
    if ($connection->query($sql) === TRUE) {
        $response['success'] = true;
    } else {
        $response['error'] = 'Error on deleting the user.';
    }
}

echo json_encode($response);

// Close the database connection
$connection->close();
?>
