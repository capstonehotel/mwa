<?php 
require_once("../../includes/initialize.php");

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
	case 'add' :
	doInsert();
	break;
	
	case 'edit' :
	doEdit();
	break;

	case 'editimage' :
	editImg();
	break;
	
	case 'delete' :
	doDelete();
	break;


	}
function doInsert(){
		if (!isset($_FILES['image']['tmp_name'])) {
			message("No Image Selected!", "error");
			redirect("index.php?view=add");
		    	}else{

				$file=$_FILES['image']['tmp_name'];
				$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
				$image_name= addslashes($_FILES['image']['name']);
				$image_size= getimagesize($_FILES['image']['tmp_name']);

				if ($image_size==FALSE) {
					message("That's not an image!", "error");
					redirect("index.php?view=add");
				}else{

			$location="rooms/".$_FILES["image"]["name"];

			// if(file_exists($location)){
			
		 //    	message("There is such an image. Please select another one!", "error");
			// 	redirect("index.php?view=add");	
			// }
			// else{
			move_uploaded_file($_FILES["image"]["tmp_name"],"rooms/".$_FILES["image"]["name"]);
			
			if ($_POST['ROOM'] == "" OR $_POST['ROOMNUM'] == "" OR $_POST['PRICE'] == "") {
				$messageStats = false;
					message("All fields required!", "error");
					redirect("index.php?view=add");
				
			}else{
				$room = new Room();

					// $_POST['ROOM'];
				// 	// $_POST['ACCOMID']
				// 	// $_POST['ROOMNUM'];
				// 	// $_POST['ROOMDESC'];
				// 	// $_POST['NUMPERSON'];
				// 	// $_POST['PRICE'];
 

				$res = $room->find_all_room($_POST['ROOM']);
				
				
				if ($res >=1) {
					message("Room name already exist!", "error");
					redirect("index.php?view=add");
				}else{
				
					 
				$room->ROOMNUM 		=	$_POST['ROOMNUM'];
				$room->ROOM 		=	$_POST['ROOM'];
				$room->ACCOMID 		=	$_POST['ACCOMID'];
				$room->ROOMDESC 	=	$_POST['ROOMDESC'];
				$room->NUMPERSON 	=	$_POST['NUMPERSON'];
				$room->PRICE 		=	$_POST['PRICE'];
 				$room->ROOMIMAGE    = $location;
 				$room->OROOMNUM 	=	$_POST['ROOMNUM'];
					
					 $istrue = $room->create(); 
					 if ($istrue == 1){
					 	message("New [". $_POST['ROOM'] ."] created successfully!", "success");
					 	redirect('index.php');
					 	
					 }
				}	 

		
			}	



		}
	}
  }
// }
//function to modify rooms

 function doEdit(){


           		$room = new Room();
          			 
				$room->ROOMNUM 		=	$_POST['ROOMNUM'];
				$room->ROOM 		=	$_POST['ROOM'];
				$room->ACCOMID 		=	$_POST['ACCOMID'];
				$room->ROOMDESC 	=	$_POST['ROOMDESC'];
				$room->NUMPERSON 	=	$_POST['NUMPERSON'];
				$room->PRICE 		=	$_POST['PRICE'];
				$room->OROOMNUM 	=	$_POST['ROOMNUM'];
 				// $room->roomImage    = $location;
				
				$room->update($_POST['ROOMID']); 
				
			 	message($_POST['ROOM'] ." Updated successfully!", "success");
			 	unset($_SESSION['id']);
			 	redirect('index.php');
				 
}

function doDelete(){
@$id=$_POST['selector'];
		  $key = count($id);
		//multi delete using checkbox as a selector
	for($i=0;$i<$key;$i++){
	 
		$rm = new Room();
		$rm->delete($id[$i]);
	}

		message("Room already Deleted!","info");
		redirect('index.php');
 }
 
 //function to modify picture
 
function editImg (){
		if (!isset($_FILES['image']['tmp_name'])) {
			message("No Image Selected!", "error");
			redirect("index.php?view=list");
		}else{
			$file=$_FILES['image']['tmp_name'];
			$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
			$image_name= addslashes($_FILES['image']['name']);
			$image_size= getimagesize($_FILES['image']['tmp_name']);
			
			if ($image_size==FALSE) {
				message("That's not an image!");
				redirect("index.php?view=list");
		   }else{
			
		
				$location="rooms/".$_FILES["image"]["name"];
				

	 				$rm = new Room();
	          		$rm_id		= $_POST['id'];
				
			    	move_uploaded_file($_FILES["image"]["tmp_name"],"rooms/".$_FILES["image"]["name"]);
					
					$rm->ROOMIMAGE = $location;
					$rm->update($rm_id); 
					
				 	message("Room Image Upadated successfully!", "success");
				 	unset($_SESSION['id']);
				 	 redirect("index.php");
 			}
 		}
 }			 

function _deleteImage($catId)
{
    // we will return the status
    // whether the image deleted successfully
    $deleted = false;

	// get the image(s)
    $sql = "SELECT * 
            FROM room
            WHERE roomNo ";
	
	if (is_array($catId)) {
		$sql .= " IN (" . implode(',', $catId) . ")";
	} else {
		$sql .= " = {$catId}";
	}	

    $result = dbQuery($sql);
    
    if (dbNumRows($result)) {
        while ($row = dbFetchAssoc($result)) {
		extract($row);
	        // delete the image file
    	    $deleted = @unlink($roomImage);
		}	
    }
    
return $deleted;
}



?>
