<?php
session_start();
header('Content-Type: application/json');

$response = [
    'logged_in' => logged_in() // Use your existing logged_in function
];

echo json_encode($response);
?>