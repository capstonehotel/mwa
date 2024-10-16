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

      redirect( 'https://mcchmhotelreservation.com/booking/'); 

}
 
 
 

 $days = dateDiff($_POST['arrival'],$_POST['departure']); 

if($days <= 0){
  $msg = 'Available room today';
}else{
   $msg =  'Available room From:'.$_POST['arrival']. ' To: ' .$_POST['departure'];

} 


$_SESSION['arrival'] = date_format(date_create( $_POST['arrival']),"Y-m-d");
$_SESSION['departure'] =date_format(date_create($_POST['departure']),"Y-m-d");


 


   $accomodation = ' | ' ;
  ?>
<div class="card rounded" style="padding: 10px;">
    <div  class="pagetitle">   
        <h1  ><?php print $title ; ?> 
        <small><?php print  $accomodation; ?></small>
        </h1> 
    </div>
    <nav aria-label="breadcrumb" >
      <ol class="breadcrumb" style="margin-top: 10px;">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php print $title  ; ?></li>
        <li class="breadcrumb-item " style="color: #02aace; float:right"> <?php print  $msg; ?></li>
      </ol>
    </nav>
    <div class="container">
        <div class="row">
            <?php 
 
                  $arrival =  $_SESSION['arrival'];
                  $departure =  $_SESSION['departure'] ;
                   $query = "SELECT * FROM `tblroom` r ,`tblaccomodation` a WHERE r.`ACCOMID`=a.`ACCOMID`  AND `NUMPERSON` >= " . $_POST['person'];
                   $mydb->setQuery($query);
                   $cur = $mydb->loadResultList(); 
                      foreach ($cur as $result) { 

// filtering the rooms
 // ======================================================================================================            
                   
                    $mydb->setQuery("SELECT * FROM `tblreservation`     WHERE ((
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
                    $rows = mysqli_fetch_assoc($stats);
                    $status=isset($rows['STATUS'])? $rows['STATUS'] : '';

                     
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
                            <input type="submit" class="btn monbela-btn  btn-primary btn-sm" id="booknow" name="booknow" onclick="return validateBook();" value="Book Now!"/>
                                                   
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
<style>
 /* Add scrollable review section */
 .scrollable-reviews {
    max-height: 300px; /* Increased height */
    overflow-y: auto;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    margin-top: 15px;
    margin-top: 15px;
    width: calc(100% - 20px); /* Same width as comment-card, minus padding */
    margin-left: auto;
    margin-right: auto;
    box-sizing: border-box; /* Ensures padding is included in width */
}


.review-item {
    margin-bottom: 10px;
}

/* Adjust star rating and comment section */
.comment-section {
    display: flex;
    flex-direction: column;
    margin-top: 20px;
    align-self: flex-start;
}

.comment-section label {
    font-weight: bold;
    margin-bottom: 10px;
}

.star-rating {
    direction: rtl;
    display: inline-flex;
    font-size: 1.5em;
    margin-bottom: 10px;
    align-self: flex-start;
}

.star-rating input {
    display: none;
}

.star-rating label {
    color: #ddd;
    cursor: pointer;
}

.star-rating label:hover, 
.star-rating label:hover ~ label,
.star-rating input:checked ~ label {
    color: #f5c518;
}

.comment-card {
    width: 100%;
    margin-bottom: 10px;
}

.comment-card textarea {
    width: 100%;
    height: 100px;
    border-radius: 5px;
    border: 1px solid #ccc;
    padding: 10px;
    resize: none;
}

.comment-buttons {
    display: flex;
    justify-content: flex-end;
}

.comment-buttons button {
    margin-left: 10px;
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
                    <img class="img-responsive img-hover" src="room.jpg" style="height: 250px; width: 90%;"> 
                <?php else: ?>
                    <img class="img-responsive img-hover" src="../admin/mod_room/<?php echo $result->ROOMIMAGE; ?>" style="height: 250px; width: 90%;"> 
                <?php endif; ?>
            </a>
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

<!-- Modal -->
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

            <!-- Star Rating System -->
            <!-- <div class="star-rating">
                <input type="radio" id="5-stars<?php echo $result->ROOMID; ?>" name="rating<?php echo $result->ROOMID; ?>" value="5" />
                <label for="5-stars<?php echo $result->ROOMID; ?>" class="star">&#9733;</label>
                <input type="radio" id="4-stars<?php echo $result->ROOMID; ?>" name="rating<?php echo $result->ROOMID; ?>" value="4" />
                <label for="4-stars<?php echo $result->ROOMID; ?>" class="star">&#9733;</label>
                <input type="radio" id="3-stars<?php echo $result->ROOMID; ?>" name="rating<?php echo $result->ROOMID; ?>" value="3" />
                <label for="3-stars<?php echo $result->ROOMID; ?>" class="star">&#9733;</label>
                <input type="radio" id="2-stars<?php echo $result->ROOMID; ?>" name="rating<?php echo $result->ROOMID; ?>" value="2" />
                <label for="2-stars<?php echo $result->ROOMID; ?>" class="star">&#9733;</label>
                <input type="radio" id="1-star<?php echo $result->ROOMID; ?>" name="rating<?php echo $result->ROOMID; ?>" value="1" />
                <label for="1-star<?php echo $result->ROOMID; ?>" class="star">&#9733;</label>
            </div> -->

            <form method="POST" action="index.php?p=accomodation">
                <input type="hidden" name="ROOMPRICE" value="<?php echo $result->PRICE ;?>">
                <input type="hidden" name="ROOMID" value="<?php echo $result->ROOMID ;?>">
                <?php echo $btn ;?>
            </form>
        </div>
       <!-- Comment Section -->
                    <div class="comment-section">
                        <!-- Comment Label and Star Rating aligned to left -->
                        <label for="comment">Leave a Comment:</label>
                        <div class="star-rating">
                            <input type="radio" id="5-stars-comment<?php echo $result->ROOMID; ?>" name="rating-comment<?php echo $result->ROOMID; ?>" value="5" />
                            <label for="5-stars-comment<?php echo $result->ROOMID; ?>" class="star">&#9733;</label>
                            <input type="radio" id="4-stars-comment<?php echo $result->ROOMID; ?>" name="rating-comment<?php echo $result->ROOMID; ?>" value="4" />
                            <label for="4-stars-comment<?php echo $result->ROOMID; ?>" class="star">&#9733;</label>
                            <input type="radio" id="3-stars-comment<?php echo $result->ROOMID; ?>" name="rating-comment<?php echo $result->ROOMID; ?>" value="3" />
                            <label for="3-stars-comment<?php echo $result->ROOMID; ?>" class="star">&#9733;</label>
                            <input type="radio" id="2-stars-comment<?php echo $result->ROOMID; ?>" name="rating-comment<?php echo $result->ROOMID; ?>" value="2" />
                            <label for="2-stars-comment<?php echo $result->ROOMID; ?>" class="star">&#9733;</label>
                            <input type="radio" id="1-star-comment<?php echo $result->ROOMID; ?>" name="rating-comment<?php echo $result->ROOMID; ?>" value="1" />
                            <label for="1-star-comment<?php echo $result->ROOMID; ?>" class="star">&#9733;</label>
                        </div>

                        <!-- Comment Message Card -->
                        <div class="comment-card">
                            <textarea name="comment" id="comment<?php echo $result->ROOMID; ?>" placeholder="Write your comment here..."></textarea>
                        </div>

                        <!-- Submit and Cancel Buttons -->
                        <div class="comment-buttons">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>

                    <div class="scrollable-reviews">
    <div class="review-item">
        <div class="review-header">
            <img src="profile1.jpg" alt="User1 Profile" class="profile-image">
            <div class="review-info">
                <strong>User1</strong>
                <div class="star-rating">
                    <span>⭐⭐⭐⭐</span> <!-- Adjust the stars accordingly -->
                </div>
            </div>
        </div>
        <p>Great room, very comfortable!</p>
    </div>
    
    <div class="review-item">
        <div class="review-header">
            <img src="profile2.jpg" alt="User2 Profile" class="profile-image">
            <div class="review-info">
                <strong>User2</strong>
                <div class="star-rating">
                    <span>⭐⭐⭐</span>
                </div>
            </div>
        </div>
        <p>Nice view, but could be cleaner.</p>
    </div>
                        <div class="review-item">
                            <strong>User3:</strong>
                            <p>Excellent service and good ambiance.</p>
                        </div>
                        <div class="review-item">
                            <strong>User3:</strong>
                            <p>Excellent service and good ambiance.</p>
                        </div>
                        <div class="review-item">
                            <strong>User3:</strong>
                            <p>Excellent service and good ambiance.</p>
                        </div>
                        <div class="review-item">
                            <strong>User3:</strong>
                            <p>Excellent service and good ambiance.</p>
                        </div>
                        <div class="review-item">
                            <strong>User3:</strong>
                            <p>Excellent service and good ambiance.</p>
                        </div>
                        <!-- Add more reviews dynamically -->
                    </div>
                </div>
</div>

       
    </div>
</div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> -->
<!-- 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> -->

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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // XSS Detection Function
        function detectXSS(inputField, fieldName) {
            const xssPattern = /[<>:\/\$\;\,\?\!]/;
            inputField.addEventListener('input', function() {
                if (xssPattern.test(this.value)) {
                    Swal.fire("XSS Detected", `Please avoid using invalid characters in your ${fieldName}.`, "error");
                    this.value = "";
                }
            });
        }
        const commentInput = document.getElementById('comment<?php echo $result->ROOMID; ?>'); // Comment field
        detectXSS(commentInput, 'Comment'); // XSS detection for the comment card
    });
</script>



<?php  

}

?>
</div>
</div>
</div>


                    