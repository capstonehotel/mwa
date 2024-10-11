<?php
require_once("../../includes/initialize.php");

if (!isset($_SESSION['ADMIN_ID'])){
    redirect("../login.php");
}

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
$title = "Room";

switch ($view) {
    case 'list':
        $content = 'list.php';
        break;

    case 'add':
        $content = 'add.php';
        break;

    case 'edit':
        $content = 'edit.php';
        break;

    case 'editpic':
        $content = 'editpic.php';
        break;

    case 'view':
        $content = 'view.php';
        break;

    default:
        $content = 'list.php';  // Default view is the list of rooms
}

// No need to handle 'delete' case as it's managed via AJAX in list.php

require_once '../themes/backendTemplate.php';
?>
