<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
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
  
$guest = New Guest();
$res = $guest->single_guest($_SESSION['GUESTID']);

?>
<div class="container " style="max-width: 1000px; padding: 20px; margin-top: 20px;">
  <div class="row card">
  	<div class="table-responsive">

  		<table class="table caption-top" style="width: 950px;">
			  <caption >
			  	<h4>List Booked Rooms </h4>
			  	<div style="flex: 1;">
			  		<a href="../index.php" class="btn btn-primary">Back Home</a>
			  	</div>
			  </caption>
			  <thead>
			    <tr>
			      <th scope="col" width="120">Room</th>
			      <th scope="col" width="120">Check In</th>
			      <th scope="col" width="120">Check Out</th>
			      <th scope="col" width="120">Price</th>
			      <th scope="col" width="120">Nights</th>
            <th scope="col" width="120">Amount</th>
			    </tr>
			  </thead>
			  <tbody>
			    <?php
         
       $query="SELECT * 
        FROM  `tblreservation` r,   `tblroom` rm, tblaccomodation a
        WHERE r.`ROOMID` = rm.`ROOMID` 
        AND a.`ACCOMID` = rm.`ACCOMID`  
        AND  r.`GUESTID` = ".$_SESSION['GUESTID'];
        $mydb->setQuery($query);
        $res = $mydb->loadResultList();

foreach ($res as $result) {
     $day = (dateDiff($result->ARRIVAL,$result->DEPARTURE)>0)?dateDiff($result->ARRIVAL,$result->DEPARTURE):'1';
       
            echo '<tr>';  
               echo '<td>'. $result->ROOM.' '. $result->ROOMDESC.' </td>';
                        echo '<td>'.date_format(date_create($result->ARRIVAL),"m/d/Y").'</td>';
                        echo '<td>'.date_format(date_create($result->DEPARTURE),"m/d/Y").'</td>';
                        echo '<td > &#8369 '. $result->PRICE.'</td>'; 
                        echo '<td>'.$day.'</td>';
                        echo '<td > &#8369 '. $result->RPRICE.'</td>';
              
              echo '</tr>';
         
        }
        ?> 
			  </tbody>
			</table>
  	</div>
	</div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
</html>