 <?php 
require_once("../includes/initialize.php");
//echo date_format(date_create($_POST['dbirth']), 'Y-m-d');
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
if(isset($_POST['submit'])){
$guest = New Guest();
$guest->G_FNAME          = $_POST['name'];    
$guest->G_LNAME          = $_POST['last']; 
$guest->G_GENDER         = $_POST['gender']; 
$guest->G_CITY           = $_POST['city'];
$guest->G_ADDRESS        = $_POST['address'] ;      
$guest->DBIRTH           = date_format(date_create($_POST['dbirth']), 'Y-m-d');   
$guest->G_PHONE          = $_POST['phone'];    
$guest->G_NATIONALITY    = $_POST['nationality'];          
$guest->G_COMPANY        = $_POST['company'];      
$guest->G_CADDRESS       = $_POST['caddress'];         
// $guest->G_UNAME          = $_POST['username'];    
// $guest->G_PASS           = sha1($_POST['pass']);    
$guest->ZIP              = $_POST['zip'];
$guest->update($_SESSION['GUESTID']); 

?>
<script type="text/javascript">
	window.location = 'https://mcchmhotelreservation.com/index.php';
</script>

<?php  } 

if(isset($_POST['savephoto'])){
	if (!isset($_FILES['image']['tmp_name'])) {
			message("No Image Selected!", "error");
			 redirect("https://mcchmhotelreservation.com/index.php");
		}else{
			$file=$_FILES['image']['tmp_name'];
			$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
			$image_name= addslashes($_FILES['image']['name']);
			$image_size= getimagesize($_FILES['image']['tmp_name']);
			
			if ($image_size==FALSE) {
				message("That's not an image!");
				redirect("https://mcchmhotelreservation.com/index.php");
		   }else{
			
		
				$location= "guest/photos/".$_FILES["image"]["name"];
				
				move_uploaded_file($_FILES["image"]["tmp_name"], "photos/".$_FILES["image"]["name"]);
				
	 				$g = new Guest(); 
			    	
					$g->LOCATION = $location;
					$g->update($_SESSION['GUESTID']); 
					
				 	// message("Room Image Upadated successfully!", "success");
				 	// unset($_SESSION['id']);
				 	 redirect("https://mcchmhotelreservation.com/index.php");
 			}
 		}

}

?>
