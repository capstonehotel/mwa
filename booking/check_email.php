<?php
require_once '../includes/initialize.php';
if (isset($_POST['email'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    // Check if the email already exists in the database
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tblguest WHERE G_UNAME = :G_UNAME");
    $stmt->execute(['email' => $email]);
    $emailCount = $stmt->fetchColumn();

    if ($emailCount > 0) {
        echo json_encode(['status' => 'unavailable']);
    } else {
        echo json_encode(['status' => 'available']);
    }
}
?>