<?php
$msg = "";

if(isset($_POST['booknow'])){

    $days =0;
    $day = dateDiff($_SESSION['arrival'],$_SESSION['departure']);  

   if($day <= 0){
      $totalprice = $_POST['ROOMPRICE'] *1;
      $days = 1;
    }else{
      $totalprice = $_POST['ROOMPRICE'] * $day;
      $days = $day;
    }
     
      addtocart($_POST['ROOMID'],$days, $totalprice,$_SESSION['arrival'],$_SESSION['departure']);

      redirect('https://mcchmhotelreservation.com/booking/'); 

}
 

 if(!isset($_SESSION['arrival'])){
   $_SESSION['arrival'] = date_create('Y-m-d');
 }
if(!isset($_SESSION['departure'])) {
  $_SESSION['departure'] =  date_create('Y-m-d') ;
}


if(isset($_POST['booknowA'])){ 


 $days = dateDiff($_POST['arrival'],$_POST['departure']); 

if($days <= 0){
  $msg = 'Available room today';
}else{
   $msg =  'Available room From:'.$_POST['arrival']. ' To: ' .$_POST['departure'];

} 


$_SESSION['arrival'] = date_format(date_create( $_POST['arrival']),"Y-m-d");
$_SESSION['departure'] =date_format(date_create($_POST['departure']),"Y-m-d");


 
 $query = "SELECT * FROM `tblroom` r ,`tblaccomodation` a WHERE r.`ACCOMID`=a.`ACCOMID`   AND `NUMPERSON` = " . $_POST['person'];
    

}elseif(isset($_GET['q'])){

    $query = "SELECT * FROM `tblroom` r ,`tblaccomodation` a WHERE r.`ACCOMID`=a.`ACCOMID` AND `ROOM`='" . $_GET['q'] . "'"; 
   
  
  }else{
     $query = "SELECT * FROM `tblroom` r ,`tblaccomodation` a WHERE r.`ACCOMID`=a.`ACCOMID`";
  }

   $accomodation = ' | ' . @$_GET['q'];
  ?>

<div class="card rounded" style="padding: 10px;">
    <div  class="pagetitle">   
        <h1  ><?php print $title ; ?> 
        </h1> 
    </div>
    <nav aria-label="breadcrumb" >
      <ol class="breadcrumb" style="margin-top: 10px;">
        <li class="breadcrumb-item"><a href="https://mcchmhotelreservation.com/index.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php print $title  ; ?></li>
        <li class="breadcrumb-item " style="color: #02aace; float:right"> <?php print  $msg; ?></li>
      </ol>
    </nav>
    
    <div class="container">
        <div class="row">
            <?php 
 
                  $arrival =  $_SESSION['arrival'];
                  $departure =  $_SESSION['departure'] ;

                   $mydb->setQuery($query);
                   $cur = $mydb->loadResultList(); 
                      foreach ($cur as $result) {   


// filtering the rooms
 // ======================================================================================================
                    $mydb->setQuery("SELECT * FROM `tblreservation`     WHERE STATUS<>'Pending' AND ((
                        '$arrival' >= DATE_FORMAT(`ARRIVAL`,'%Y-%m-%d')
                        AND  '$arrival' <= DATE_FORMAT(`DEPARTURE`,'%Y-%m-%d')
                        )
                        OR (
                        '$departure' >= DATE_FORMAT(`ARRIVAL`,'%Y-%m-%d')
                        AND  '$departure' <= DATE_FORMAT(`DEPARTURE`,'%Y-%m-%d')
                        )
                        OR (
                        DATE_FORMAT(`ARRIVAL`,'%Y-%m-%d') >=  '$arrival'
                        AND DATE_FORMAT(`ARRIVAL`,'%Y-%m-%d') <=  '$departure'
                        )
                        )
                        AND ROOMID =".$result->ROOMID);

                    

                     $curs = $mydb->loadResultList(); 
                     
                     $resNum = $result->ROOMNUM - count($curs) ;
                         


                    $stats = $mydb->executeQuery();
                    $rows = $mydb->fetch_array($stats);
                    $status=isset($rows['STATUS']) ? $rows['STATUS'] : '';

                     
                    //$availRoom = $result->ROOMNUM;


              if($resNum<=0){

             if($status=='Confirmed'){
                $btn =  '<div style="margin-top:10px; color: rgba(0,0,0,1); font-size:16px;"><strong>Fully Reserve!</strong></div>';
                 $img_title = ' 

                           <figcaption class="img-title-active">
                                <h5>Reserve!</h5>    
                            </figcaption>


                    ';
              }elseif($status=='Checkedin'){
                $btn =  '<div style="margin-top:10px; color: rgba(0,0,0,1); font-size:16px;"><strong>Fully Book!</strong></div>';
                 $img_title = ' 

                           <figcaption class="img-title-active">
                                <h5>Book!</h5>    
                            </figcaption>


                    ';
              }else{    
                 $btn =  '
                 <div class="form-group">
                        <div class="row">
                          <div class="col-xs-12 col-sm-12">
                            <input type="submit" class="btn monbela-btn  btn-warning btn-sm" id="booknow" name="booknow" onclick="return validateBook();" disabled value="No rooms Available!"/>
                                                   
                           </div>
                        </div>
                      </div>';
                    $img_title = ' 

                           <figcaption class="img-title">
                                <h5>'.$result->ROOM . ' <br/> '.$result->ROOMDESC.'  <br/>
                                ' . $result->ACCOMODATION .' <br/> 
                                '.$result->ACCOMDESC . '<br/>  
                                Number of Person:' . $result->NUMPERSON .' <br/> 
                                Price:'.$result->PRICE.'</h5>    
                            </figcaption>


                    ';
                   
              }
                   
              }else{
                $btn =  '
                 <div class="form-group">
                        <div class="row">
                          <div class="col-xs-12 col-sm-12">
                            <input type="submit" class="btn monbela-btn  btn-primary btn-sm" id="booknow" name="booknow" onclick="return validateBook();"  value="Book Now!"/>
                                                   
                           </div>
                        </div>
                      </div>';
                    $img_title = ' 

                           <figcaption class="img-title">
                                <h5>'.$result->ROOM . ' <br/> '.$result->ROOMDESC.'  <br/>
                                ' . $result->ACCOMODATION .' <br/> 
                                '.$result->ACCOMDESC . '<br/>  
                                Number of Person:' . $result->NUMPERSON .' <br/> 
                                Price:'.$result->PRICE.'</h5>    
                            </figcaption>


                    ';
                   

              }      
// ============================================================================================================================

 
                ?>
                <style>
   .img-hover {
    transition: transform 0.3s ease;
    cursor: pointer;
    object-fit: cover; /* Prevents the image from stretching */
 
}

.img-hover:hover {
    transform: scale(1.1); /* Adjust the scale factor for zoom effect */
}
.modal.zoom .modal-dialog {
    
    transform: scale(1);
    transition: transform 0.3s ease-out;
}
.modal.zoom.show .modal-dialog {
    transform: scale(1);
}
.img-container {
    overflow: hidden;
width: 100%;
height: 100%;
position: relative;
display: flex;
justify-content: center;
align-items: center;
}
.img-container img {
    width: 100%;
    transition: width 0.3s ease;
}
.zoom-buttons {
    position: absolute;
    bottom: 10px;
    right: 10px;
    display: flex;
    flex-direction: column;
}
.zoom-buttons button {
    margin: 2px;
    background: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    padding: 5px;
    border-radius: 3px;
}
.zoom-buttons button i {
    pointer-events: none;
}
</style>
                <div class="col-md-4 col-sm-12 py-2">
                    <form method="POST" action="index.php?p=accomodation">
                        <input type="hidden" name="ROOMPRICE" value="<?php echo $result->PRICE ;?>">
                        <input type="hidden" name="ROOMID" value="<?php echo $result->ROOMID ;?>">
                        <div class="card">
                            <figure class="gallery-item" style="text-align: center; margin-top: 10px;">
                            <a href="#" data-toggle="modal" data-target="#roomModal<?php echo $result->ROOMID; ?>">
                                <?php if(is_file('https://mcchmhotelreservation.com/admin/mod_room/'.$result->ROOMIMAGE)): ?>
                                <img class="img-responsive img-hover"  src="room.jpg" style="height: 250px; width: 90%;"> 
                               <?php echo 'https://mcchmhotelreservation.com/admin/mod_room/'.$result->ROOMIMAGE; ?>
                                <?php else: ?>
                                 <img class="img-responsive img-hover"  src="../admin/mod_room/<?php echo $result->ROOMIMAGE ?> " style="height: 250px; width: 90%;"> 
                                <?php endif; ?>
                                </a>
                                <!--  <?php echo $img_title; ?>  -->
                                <figcaption class="img-title-active"><br>
                                    <h5> &#8369 <?php echo $result->PRICE ;?></h5>    
                                </figcaption>
                                </figure>
                                <div class="descRoom">
            <ul>
                <h4><p><?php echo $result->ROOM ;?></p></h4>
                <li><?php echo $result->ROOMDESC ;?></li>
                <li>Number Person : <?php echo $result->NUMPERSON ;?></li>
                <li>Remaining Rooms : <?php echo $resNum ;?></li>   
                <li style="list-style:none; text-align: center; margin: 20px 25px 0 0;"><?php echo $btn ;?></li>  
            </ul>
        </div>
                            
                        </div>
                    </form>
                 </div>
                 <div class="modal fade zoom" id="roomModal<?php echo $result->ROOMID; ?>" tabindex="-1" role="dialog" aria-labelledby="roomModalLabel<?php echo $result->ROOMID; ?>" aria-hidden="true">
<div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="roomModalLabel<?php echo $result->ROOMID; ?>"><?php echo $result->ROOM; ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="img-container">
                        <?php if(is_file('https://mcchmhotelreservation.com/admin/mod_room/'.$result->ROOMIMAGE)): ?>
                            <img id="roomImage<?php echo $result->ROOMID; ?>" class="img-responsive img-hover" src="room.jpg"> 
                        <?php else: ?>
                            <img id="roomImage<?php echo $result->ROOMID; ?>" class="img-responsive img-hover" src="../admin/mod_room/<?php echo $result->ROOMIMAGE; ?>"> 
                        <?php endif; ?>
                        <div class="zoom-buttons">
                            <button id="zoomInBtn<?php echo $result->ROOMID; ?>" class="btn btn-secondary btn-sm" data-zoom="1.3"><i class="fas fa-search-plus"></i></button>
                            <button id="zoomOutBtn<?php echo $result->ROOMID; ?>" class="btn btn-secondary btn-sm" data-zoom="0.7"><i class="fas fa-search-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6"> 
                    
                    <ul>
                    <h4><p> &#8369 <?php echo $result->PRICE ;?></p></h4>
                <li><?php echo $result->ROOMDESC ;?></li>
                <li>Number Person : <?php echo $result->NUMPERSON ;?></li>
                <li>Remaining Rooms : <?php echo $resNum ;?></li> 
                    </ul>
                    <form method="POST" action="index.php?p=accomodation">
                        <input type="hidden" name="ROOMPRICE" value="<?php echo $result->PRICE ;?>">
                        <input type="hidden" name="ROOMID" value="<?php echo $result->ROOMID ;?>">
                        <?php echo $btn ;?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>       
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@panzoom/panzoom@4.5.1/dist/panzoom.min.js"></script>
<script>
$(document).ready(function () {
$('[id^="roomModal"]').on('shown.bs.modal', function () {
    const roomId = $(this).attr('id').replace('roomModal', '');
    const img = document.getElementById('roomImage' + roomId);

    if (!img) {
        console.error('Image element not found');
        return;
    }

    // Initialize Panzoom on the image
    const panzoom = Panzoom(img, {
        maxScale: 3, // Adjust max zoom level if needed
        minScale: 1, // Minimum zoom level
        contain: 'outside' // Prevent zooming out of view
    });

    // Zoom buttons
    const zoomInBtn = document.getElementById('zoomInBtn' + roomId);
    const zoomOutBtn = document.getElementById('zoomOutBtn' + roomId);

    $(zoomInBtn).on('click', function () {
        panzoom.zoomIn(); // Zoom in using Panzoom
    });

    $(zoomOutBtn).on('click', function () {
        panzoom.zoomOut(); // Zoom out using Panzoom
    });

    // Reset Panzoom when modal is closed
    $('[id^="roomModal"]').on('hidden.bs.modal', function () {
        panzoom.reset(); // Reset the zoom and pan when the modal is closed
    });
});
});

</script>





<?php  

}

?>

        </div>
    </div> 
</div>