<?php
// require_once ("initialize.php"); 
// session_start();

// $response = array();
// $response['logged_in'] = isset($_SESSION['GUESTID']) || isset($_COOKIE['user_logged_in']);

// header('Content-Type: application/json');
// echo json_encode($response);

// check_login.php
require_once ("initialize.php"); 
session_start();

// Read the global token from the file
$globalToken = file_get_contents('global_session_token.txt');

// Check if the session token matches the global token
if (!isset($_SESSION['session_token']) || $_SESSION['session_token'] !== $globalToken) {
    // Token mismatch; logout the session
    session_destroy();
    header('Location: login.php');
    exit();
}

?>