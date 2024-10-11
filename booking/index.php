<?php
require_once("../includes/initialize.php"); 

// // load config file first 
// require_once("../includes/config.php");
// //load basic functions next so that everything after can use them
// require_once("../includes/functions.php");
// //later here where we are going to put our class session
// require_once("../includes/session.php");
// require_once("../includes/user.php");
// require_once("../includes/pagination.php");
// require_once("../includes/paginsubject.php");
// require_once("../includes/accomodation.php");
// require_once("../includes/guest.php");
// require_once("../includes/reserve.php"); 
// require_once("../includes/setting.php");
// //Load Core objects
// require_once("../includes/database.php");

//load database-related classes

// $menus=array("Home Page"=>"home.php","About Us"=>"about.php","Booking"=>"booking.php","Admin"=>"services.php","Latest News"=>"latest.php","contacts"=>"contact.php");
$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
$account = '../guest/update.php'; 
$small_nav = '../theme/small-navbar.php';
switch ($view) {
	case 'booking' :
	    $title="Booking";
		$content    = 'booking.php';		
		break;

	case 'logininfo' :
	    $title="Booking";
		$content    = 'logininfo.php';		
		break; 

	case 'payment':
	    $title="Booking";
   		$content    = 'payment.php';		
		break;

	case 'detail' :
	    $title="Booking";
		$content    = 'reservation.php';
		break;
	case 'mpesa' :
	    $title="Booking";
		$content    = 'detail.php';
		break;

	default :
	    $title="Booking";
		$content    = 'booking.php';		
}
include '../theme/template.php';
// include  '../guest/update.php';
?> 