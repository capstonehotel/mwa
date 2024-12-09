<?php
require_once ("initialize.php"); 
session_start();

$response = array();
$response['logged_in'] = isset($_SESSION['GUESTID']) || isset($_COOKIE['user_logged_in']);

header('Content-Type: application/json');
echo json_encode($response);
?>