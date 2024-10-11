<?php 
 require_once("initialize.php");
// // // include 'config.php'; 
// require_once("includes/config.php");
// //load basic functions next so that everything after can use them
// require_once("includes/functions.php");
// //later here where we are going to put our class session
// require_once("includes/session.php");
// require_once("includes/user.php");
// require_once("includes/pagination.php");
// require_once("includes/paginsubject.php");
// require_once("includes/accomodation.php");
// require_once("includes/guest.php");
// require_once("includes/reserve.php"); 
// require_once("includes/setting.php");
// //Load Core objects
// require_once("includes/database.php");



// require_once("includes/initialize.php");
$content='home.php';
$view = (isset($_GET['p']) && $_GET['p'] != '') ? $_GET['p'] : '';
$account = 'guest/update.php';
$small_nav = 'theme/small-navbar.php';
switch ($view) {

  case '1' :
        $title="Home";  
        $content='home.php';    
    break;
  case '2' :
      $title="Gallery"; 
    $content ='gallery.php';
    break;
  case '3' :
      $title="About Us";  
    $content = 'about.php';   
    break;

   case 'rooms' :
    $title="Rooms and Rates";  
    $content ='room_rates.php';    
    break;

  case 'contact' :
      $title="Contacts";  
    $content ='contact.php';    
    break;

  case 'about-us' :
      $title="About Us";  
    $content ='about_us.php';    
    break;

 case 'booking' :
      $title="Book A Room";  
    $content ='bookAroom.php';    
    break;
        
  case 'accomodation' :
      $title="Accomodation";  
      $content='accomodation.php';
    break;  

  case 'largeview' :
      // $title="View";  
    $content ='largeimg.php';
    break;
  default :
      $title="Home";  
    $content ='home.php';   
}

  include ('theme/template.php');

?>
 
