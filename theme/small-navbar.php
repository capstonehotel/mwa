<?php 
 
  // if (isset($_SESSION['GUESTID'])) {
    # code...
?>
<!-- <div id="sidr-close"><a href="#sidr-close" class="toggle-sidr-close"></a></div>
  <div id="sm-wrap ">
    <a href="#menuSm" id="navigation-toggle"><span class="fa fa-bars"></span>Menu</a> -->
 
<nav  id="menuSm"  class="navbar navbar-fixed-top navbar-inverse container" > 
    <div class="container " > 
    <div class="navbar-header">
          <!-- <h5 class="navbar-menu p" >GC Appliance Centrum Corp</h5> -->
         <button type="button" class="navbar-toggle btn-xs p" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button> 
    </div> 
    <div class="collapse navbar-collapse ">
      <div class="sm-ul navbar-custom-menu ">
          <ul class="nav navbar-nav  tooltip-demo">
            <li>
              <a  data-toggle="tooltip" data-placement="bottom"   title="Booking Cart"  href="<?php echo 'https://mcchmhotelreservation.com/booking/index.php';  ?>"> 
               <i class="fa fa-shopping-cart fa-fw"><?php echo  isset($cart) ? $cart : '' ; ?>  </i> 
             </a>
            </li>


            <?php if (isset($_SESSION['GUESTID'])) {
              # code...
            ?>
            
          
             <!-- Messages: style can be found in dropdown.less-->
             <?php 

             $sql = "SELECT count(*) as MSG FROM `tblpayment` WHERE STATUS<>'Pending'  AND  `MSGVIEW`=0 AND `GUESTID`=" . $_SESSION['GUESTID'];
             $mydb->setQuery($sql);
             $res =$mydb->executeQuery(); 

               $msgCnt = $mydb->fetch_array($res);
              ?>
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success"><?php echo $msgCnt['MSG'] ; ?></span>
              <i class="fa fa-caret-down fa-fw"></i> 
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <?php echo $msgCnt['MSG'] ; ?> messages</li>
              <?php 
             $sql = "SELECT  *  FROM `tblpayment` WHERE STATUS<>'Pending' AND `MSGVIEW`=0 AND `GUESTID`=" . $_SESSION['GUESTID'];
             $mydb->setQuery($sql);
             $res = $mydb->executeQuery($sql); 
                while ($row = $mydb->fetch_array($res)){
               ?>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a class="read" href="#" data-toggle="modal" data-target="#myModal" data-id="<?php echo $row['CONFIRMATIONCODE']; ?>">
    <div class="pull-left">
        <img src="../images/1607134500_avatar.jpg" class="img-circle" alt="">
    </div>
    <h4>Admin</h4>
    <p>Reservation is already <?php echo $row['STATUS']; ?>..</p>
</a>                  </li>
           
                
                </ul>
              </li>
              <!-- <li class="footer"><a href="#">See All Messages</a></li> -->
              <?php } ?>
            </ul>
          </li>

<?php 
$g = New Guest() ;
$result = $g->single_guest($_SESSION['GUESTID']);

?>

          
            <!-- User Account: style can be found in dropdown.less -->
 
            <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            
              <!-- <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
            <i class="fa fa-user fa-fw"></i><?php echo $_SESSION['name']. ' ' . $_SESSION['last']; ?> <i class="fa fa-caret-down fa-fw"></i> 

            </a>
            <ul class="dropdown-menu nav nav-stacked">   
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <li class="widget-user-header bg-yellow">
              <div class="widget-user-image" style="padding-top: 20px;">
                <img class="img-circle" style="cursor:pointer;width:100px;height:100px;padding:0;"  data-target="#myModal" data-toggle="modal" src="<?php echo WEB_ROOT.'images/user_avatar/'.$result->G_AVATAR;  ?>" alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?php echo $_SESSION['name']. ' ' . $_SESSION['last']; ?> </h3>
              <!-- <h5 class="widget-user-desc">Lead Developer</h5> -->
            </li>
            <!-- <li class="box-footer no-padding">  -->
                <li><a style="color:#000;text-align:left;border-bottom:1px solid #fff;"
                    href="https://mcchmhotelreservation.com/guest/profile.php" data-toggle="lightbox" >Account<!--  <span class="pull-right badge bg-blue">31</span> --></a></li>
                <!-- <li><a style="color:#000;text-align:left;border-bottom:1px solid #fff;" href="#">Tasks <span class="pull-right badge bg-aqua">5</span></a></li> -->
                <li><a style="color:#000;text-align:left;border-bottom:1px solid #fff;" 
                href="https://mcchmhotelreservation.com/guest/bookinglist.php" data-toggle="lightbox">Bookings <!-- <span class="pull-right badge bg-green">12</span> --></a></li>
                <li><a style="color:#000;text-align:left;border-bottom:1px solid #fff;" href="<?php echo 'https://mcchmhotelreservation.com/logout.php';  ?>">Logout </a></li>
            
            <!-- </li>  -->
            </ul>

          </li>
          <?php } ?>

          </ul>
      </div> 
      </div>
    </div>  

</nav>  
<?php  
 // }
?>
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Modal Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add content for your modal here -->
                Content of the modal goes here...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
 <a href="logout.php">Login-Admin</a> 