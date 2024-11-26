<?php
require_once("../../initialize.php");

if (!isset($_SESSION['ADMIN_ID'])){
    redirect(WEB_ROOT. "admin/login.php");
}

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
$title = "Chat";

switch ($view) {
    case 'list':
        $content = 'list.php';        
        break;

    default:
        $content = 'list.php';        
}

include '../modal.php';
require_once '../themes/backendTemplate.php';
?>
