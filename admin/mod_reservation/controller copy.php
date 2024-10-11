<?php
$connection = new mysqli('localhost', 'root', '', 'hmsystemdb');
require_once("../../includes/initialize.php");
require_once("../../includes/config.php");
$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';
$code = $_GET['code'];
switch ($action) {
	// case 'modify' :
	// dbMODIFY();
	// break;
	
	case 'delete' :
 
	$sql = "DELETE FROM tblreservation WHERE CONFIRMATIONCODE = '$code'";
    $sql2 = "DELETE FROM tblpayment WHERE CONFIRMATIONCODE = '$code'";


    echo '<script src="../sweetalert2.all.min.js"></script>';
    if (mysqli_query($connection, $sql)=== TRUE && mysqli_query($connection, $sql2)=== TRUE ) {
        // echo "<script> alert('Delete Booking Successfully.'); </script>";
        echo '<script src="../sweetalert2.all.min.js"></script>';
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won\'t be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "The accomodation has been deleted.",
                            icon: "success"
                        }).then(() => {
                            window.location.href = "index.php?confirm=true&code=' . $code . '";
                        });
                    } else {
                        // User clicked "Cancel", do nothing (no action needed)
                        window.location.href = "index.php";
                    }
                });
            });
            </script>';
    } else {
      echo "<script> alert('Error on Deleting Booking.'); </script>" ;
    }
    redirect('index.php');
	break;
	
	// case 'deleteOne' :
	// dbDELETEONE();
	// break;
	case 'confirm' :
        
        
        $sql = "UPDATE tblreservation r, tblroom rm SET ROOMNUM = ROOMNUM - 1 WHERE r.ROOMID=rm.ROOMID AND  CONFIRMATIONCODE = '$code' ";


        $sql1 = "UPDATE tblreservation SET STATUS = 'Confirmed' WHERE CONFIRMATIONCODE ='$code'";


        $sql2 = "UPDATE tblpayment SET STATUS = 'Confirmed' WHERE CONFIRMATIONCODE ='$code'";

        if ($connection->query($sql) === TRUE && $connection->query($sql1) === TRUE && $connection->query($sql2) === TRUE) {
            echo "<script> alert('Confirm Booking Successfully.'); </script>";
            
        } else {
            echo "<script> alert('Error on Confirming Booking.'); </script>" ;
        }
        redirect('index.php');
	break;
	case 'cancel' :
        $sql1 = "UPDATE tblreservation SET STATUS = 'Cancelled' WHERE CONFIRMATIONCODE ='$code'";
        $sql = "UPDATE tblreservation r, tblroom rm SET ROOMNUM = ROOMNUM + 1 WHERE r.ROOMID=rm.ROOMID AND  CONFIRMATIONCODE = '$code' ";

        $sql2 = "UPDATE tblpayment SET STATUS = 'Cancelled' WHERE CONFIRMATIONCODE ='$code'";

        if ($connection->query($sql1) === TRUE && $connection->query($sql2) === TRUE && $connection->query($sql) === TRUE) {
            echo "<script> alert('Cancelled Booking Successfully.'); </script>";
        } else {
            echo "<script> alert('Error on Cancelling Booking.'); </script>" ;
        }
        redirect('index.php');
	break;
	case 'checkin' :
	    $sql1 = "UPDATE tblreservation SET STATUS = 'Checkedin' WHERE CONFIRMATIONCODE ='$code'";


        $sql2 = "UPDATE tblpayment SET STATUS = 'Checkedin' WHERE CONFIRMATIONCODE ='$code'";

        if ($connection->query($sql1) === TRUE && $connection->query($sql2) === TRUE) {
            echo "<script> alert('Checkedin Booking Successfully.'); </script>";
        } else {
            echo "<script> alert('Error on Checkedin Booking.'); </script>" ;
        }
        redirect('index.php');
	break;
	case 'checkout' :
	    $sql1 = "UPDATE tblreservation SET STATUS = 'Checkedout' WHERE CONFIRMATIONCODE ='$code'";
        $sql = "UPDATE tblreservation r, tblroom rm SET ROOMNUM = ROOMNUM + 1 WHERE r.ROOMID=rm.ROOMID AND  CONFIRMATIONCODE = '$code' ";

        $sql2 = "UPDATE tblpayment SET STATUS = 'Checkedout' WHERE CONFIRMATIONCODE ='$code'";

        if ($connection->query($sql1) === TRUE && $connection->query($sql2) === TRUE && $connection->query($sql) === TRUE) {
            echo "<script> alert('Checkedout Booking Successfully.'); </script>";
        } else {
            echo "<script> alert('Error on Checkedout Booking.'); </script>" ;
        }
        redirect('index.php');
	break;
	// case 'cancelroom' :
	// 	doCancelRoom();
	// break;
	}
    
// function doCheckout(){
// 	global $mydb;

// 	// $id = $_GET['id'];

// 	// $res = new Reservation();
// 	// $res->STATUS = 'Checkedout';
// 	// $res->update($id); 
// 			$sql = "UPDATE `tblreservation` SET `STATUS`='Checkedout' WHERE `CONFIRMATIONCODE` ='" . $_GET['code'] ."'";
// 	$mydb->setQuery($sql);
// 	$mydb->executeQuery();

// 	$sql = "UPDATE `tblpayment` SET `STATUS`='Checkedout' WHERE `CONFIRMATIONCODE` ='" . $_GET['code'] ."'";
// 	$mydb->setQuery($sql);
// 	$mydb->executeQuery();
					
// 	message("Reservation Upadated successfully!", "success");
// 	redirect('index.php');
// }

// function doCheckin(){
// 	global $mydb;
// // $id = $_GET['id'];

// // $res = new Reservation();
// // $res->STATUS = 'Checkedin';
// // $res->update($id); 
// 		$sql = "UPDATE `tblreservation` SET `STATUS`='Checkedin' WHERE `CONFIRMATIONCODE` ='" . $_GET['code'] ."'";
// $mydb->setQuery($sql);
// $mydb->executeQuery();
 

// $sql = "UPDATE `tblpayment` SET `STATUS`='Checkedin' WHERE `CONFIRMATIONCODE` ='" . $_GET['code'] ."'";
// $mydb->setQuery($sql);
// $mydb->executeQuery();


//  // send e-mail to ...
// $email="kenjieearlpalacios@gmail.com";
// $to=$email;

// // Your subject
// $subject="Your confirmation link here";

// // From
// $header="from: your name <your email>";

// // Your message
// $message="Your Comfirmation link \r\n";
// $message.="Click on this link to activate your account \r\n";
// $message.="http://www.yourweb.com/confirmation.php?passkey=$confirm_code";

// // send email
// $sentmail = mail($to,$subject,$message,$header);
  

// // if your email succesfully sent
// if($sentmail){
// echo "Your Confirmation link Has Been Sent To Your Email Address.";
// }
// else {
// echo "Cannot send Confirmation link to your e-mail address";
// }
// message("Reservation Upadated successfully!", "success");
// redirect('index.php');



// }


// function doCancel(){
// 	global $mydb;
// // $id = $_GET['id'];
// 	$sql = "UPDATE `tblreservation` SET `STATUS`='Cancelled' WHERE `CONFIRMATIONCODE` ='" . $_GET['code'] ."'";
// $mydb->setQuery($sql);
// $mydb->executeQuery();
 

// // $res = new Reservation();
// // $res->STATUS = 'Cancelled';
// // $res->update($id);
// // $sql = " UPDATE `tblreservation` r,tblroom rm SET ROOMNUM=ROOMNUM + 1 WHERE r.`ROOMID`=rm.`ROOMID` AND `CONFIRMATIONCODE` ='" . $_GET['code'] ."'";
// // mysql_query($sql) or die(mysql_error());	


// // $sql = "UPDATE `tblreservation` SET `STATUS`='Cancelled' WHERE `CONFIRMATIONCODE` ='" . $_GET['code'] ."'";
// // mysql_query($sql) or die(mysql_error());


// // $sql = "UPDATE `tblpayment` SET `STATUS`='Cancelled' WHERE `CONFIRMATIONCODE` ='" . $_GET['code'] ."'";
// // mysql_query($sql) or die(mysql_error());

				
// message("Reservation Upadated successfully!", "success");
// redirect('index.php');

// }
// function doCancelRoom(){
// 	global $mydb;
// 	$id = $_GET['id'];

// 	$res = new Reservation();
// 	$res->STATUS = 'Cancelled';
// 	$res->update($id); 
// 	$mydb->setQuery("SELECT * FROM `tblreservation` WHERE  `RESERVEID` ='" . $_GET['id'] ."'");
// 	$cur = $mydb->loadResultList(); 
// 	foreach ($cur as $result) {  

// 	@$room = new Room(); 
// 	@$room->ROOMNUM = $room->ROOMNUM + 1; 
// 	@$room->update($result->ROOMID); 

// 	}


// $sql = "UPDATE `tblpayment` SET `STATUS`='Cancelled' WHERE `RESERVEID` ='" . $_GET['id'] ."'";
// mysqli_query($sql) or die(mysql_error());

				
// message("Reservation Upadated successfully!", "success");
// redirect('index.php');

// }

// function doConfirm(){
// 	global $mydb;
// // $id = $_GET['id'];

// // $res = new Reservation();
// // $res->STATUS = 'Confirmed';
// // $res->update($id);


// // Create a connection


// }	
// /*function dbMODIFY(){
// $id = $_GET['id'];
// $arrival=$_POST['arrival'];
// $departure=$_POST['departure'];
// $adults=$_POST['adults'];
// $child=$_POST['child'];
// $sql="UPDATE reservation SET arrival='$arrival', departure='$departure',adults='$adults',child='$child' WHERE reservation_id=".$id;
// $result = dbQuery($sql);
// if(!$result)
// {
//   die('Could not modify record: ' . mysql_error());
// } else {

// header('Location:index_resv.php');}
// }
// */
// /*function dbDELETEONE(){
// 	$del_id = $_GET['id'];
// 	$sql = "DELETE FROM reservation  WHERE reservation_id={$del_id}";
// 	$result = dbQuery($sql)or die('Could not delete record: ' . mysql_error());
//   header('Location:index_resv.php?view=list');
//   }*/
// ?>