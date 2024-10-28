<?php
session_start();
// include 'includes/initialize.php'; // Include your database configuration file
require_once 'initialize.php';
if (isset($_SESSION['user_id']) && isset($_POST['rating'])) {
    $userId = $_SESSION['user_id'];
    $rating = intval($_POST['rating']);
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';

    $stmt = $conn->prepare("INSERT INTO star_ratings (user_id, rating, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $userId, $rating, $comment);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>
