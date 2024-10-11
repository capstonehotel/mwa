<?php
require_once("../../includes/initialize.php");

if (!isset($_SESSION['ADMIN_ID'])){
    redirect(WEB_ROOT. "admin/login.php");
}

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
$title = "Room Type";

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

    case 'view':
        $content = 'view.php';        
        break;

    case 'delete':
        // Handle deletion via AJAX
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $sql = "DELETE FROM tblaccomodation WHERE ACCOMID = $id";
            if ($connection->query($sql) === TRUE) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error']);
            }
            exit;
        }
        break;

    default:
        $content = 'list.php';        
}

include '../modal.php';
require_once '../themes/backendTemplate.php';
?>
