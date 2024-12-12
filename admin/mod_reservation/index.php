<?php
require_once("../../includes/initialize.php");

 if (!isset($_SESSION['ADMIN_ID'])){
 	redirect(WEB_ROOT ."admin/login.php");
 }
//checkAdmin();
$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
$title ="Reservation";
switch ($view) {
	case 'list' :
		$content    = 'list.php';		
		break;

	case 'add' :
		$content    = 'add.php';		
		break;

	case 'edit' :
		$content    = 'edit.php';		
		break;
    case 'view' :
		$content    = 'view.php';		
		break;

	default :
		$content    = 'list.php';		
}
  include '../modal.php';
require_once '../themes/backendTemplate.php';


if (isset($_SESSION['alert'])) {
	$alert = $_SESSION['alert'];
	unset($_SESSION['alert']);
	echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
	echo "<script>
			Swal.fire({
			  title: '{$alert['title']}',
			  text: '{$alert['message']}',
			  icon: '{$alert['status']}'
			});
		  </script>";
  }

?>


  
