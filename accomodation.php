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

      redirect('booking/'); 

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


 
 $query = "SELECT * FROM `tblroom` r ,`tblaccomodation` a WHERE r.`ACCOMID`=a.`ACCOMID` AND `ACCOMODATION`='" . $_GET['q'] . "' AND `NUMPERSON` = " . $_POST['person'];
    

}elseif(isset($_GET['q'])){

    $query = "SELECT * FROM `tblroom` r ,`tblaccomodation` a WHERE r.`ACCOMID`=a.`ACCOMID` AND `ACCOMODATION`='" . $_GET['q'] . "'"; 
   
 
  
  }

   $accomodation = ' | ' . $_GET['q'];
  ?>
<div class="card rounded" style="padding: 10px;">
    <div  class="pagetitle">   
        <h1  ><?php  $title ; ?> 
        </h1> 
    </div>
    <nav aria-label="breadcrumb" >
      <ol class="breadcrumb" style="margin-top: 10px;">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php  $title  ; ?></li>
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
                    $rows = $mydb->fetch_array($stats);
                    $status=isset($rows['STATUS']) ? $rows['STATUS']:"";

                     
                    //$availRoom = $result->ROOMNUM;


              if($resNum==0){

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

                <div class="col-md-4 col-sm-12 py-2">
                    <form method="POST" action="index.php?p=accomodation">
                        <input type="hidden" name="ROOMPRICE" value="<?php echo $result->PRICE ;?>">
                        <input type="hidden" name="ROOMID" value="<?php echo $result->ROOMID ;?>">
                        <div class="card">
                                <figure class="gallery-item " style="text-align: center; margin-top: 10px;">
                                    <?php if(is_file("https://mcchmhotelreservation.com/admin/mod_room/".$result->ROOMIMAGE)): ?>
                                    <img class="img-responsive img-hover"  src="room.jpg">
                                   <!--  //<?php echo 'https://mcchmhotelreservation.com/admin/mod_room/'.$result->ROOMIMAGE; ?> -->
                                    <?php else: ?>
                                    <img class="img-responsive img-hover"  src="https://mcchmhotelreservation.com/admin/mod_room/<?php echo $result->ROOMIMAGE ?>" style="height: 250px; width: 90%">
                                    <?php endif; ?>
                                    <!--  <?php echo $img_title; ?>  -->
                                    <figcaption class="img-title-active">
                                        <h5> &#8369 <?php echo $result->PRICE ;?></h5>    
                                    </figcaption>
                                    <p><?php echo $result->ROOM ;?> <br> <?php echo $result->ROOMDESC ;?> <br>Number Person : <?php echo $result->NUMPERSON ;?> <br> Remaining Rooms :<?php echo  $resNum ;?> <br><?php echo $btn ;?> </p>
                     
                                </figure> 
                        </div>
                    </form>
                </div>
                <?php  
 
                 }

                ?>
        </div>
    </div>
</div>