 <!-- SIDEBAR START HERE -->
   
  <style>
      #h3{

        font-family: monospace;
        font-size: 22px;
        color: white;
      }

      #h3:hover {
       
color: aqua;
font-style: underline;


}


  </style>
 <div class="container "  style="float-left; padding-top: 0px; margin-top:0px; height: 125vh; color: white; margin-left:0px; width: 100%; border-bottom-left-radius: 4px; border-bottom-right-radius: 4px; background-color:#6d4330; ">
              <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase " style="background-color: #6d4330;">
                <!-- <img src="../admin/images/high.jpg" style="height: 80px;"> -->
                
                <p class="text-align-center "style="font-size: 35px;">HM Hotel Reservation</p>
                </div> 

           <!--------content sidebar----->

                  <div class="list-group list-group-flush my-3" >
                        

                <br>
                 <a class="<?php echo (currentpage() == 'index.php') ? "active" : false;?>list-group-item list-group-item-action bg-transparent fw-bold text-light"
                style="background-color: border-top:2px solid white; #6d4330; background-color: #6d4330; border-bottom: 2px solid white; border-top:2px solid white; border- border-bottom: 2px solid white; " href="<?php echo WEB_ROOT; ?>admin/index.php" ><h3 id="h3"><b>Home</b></h3></a>
                
              
                  <a class="<?php echo (currentpage() == 'mod_room') ? "active" : false;?>list-group-item list-group-item-action bg-transparent fw-bold text-light"
                style=" background-color: #6d4330; border-top:2px solid white; border-bottom: 2px solid white !important; border-top:1px solid white; border-radius: 0px" href="<?php echo WEB_ROOT; ?>admin/mod_room/index.php" ><h3 id="h3"><b>Rooms<b></h3></a>
              

           
                 <a class="<?php echo (currentpage() == 'mod_accomodation') ? "active" : false;?>list-group-item list-group-item-action bg-transparent fw-bold text-light"
         black  style=" background-color: #6d4330; border-bottom: 2px solid white; border-top:2px solid white;border-radius: 0px"  href="<?php echo WEB_ROOT; ?>admin/mod_accomodation/index.php" ><h3 id="h3"><b>Accomodation<b></h3></a>

                 <?php
                $query = "SELECT count(*) as 'Total' FROM `tblpayment` WHERE `STATUS`='Pending'";
                $mydb->setQuery($query);
                $cur = $mydb->loadResultList();  
                foreach ($cur as $result) { 
                ?>
            

          
                 <a class="<?php echo (currentpage() == 'mod_reservation') ? "active" : false;?>list-group-item list-group-item-action bg-transparent fw-bold text-light"
                style=" background-color: #6d4330; border-top:2px solid white;  border-bottom: 2px solid white; border-radius: 2px" href="<?php echo WEB_ROOT; ?>admin/mod_reservation/index.php" ><h3 id="h3"><b>Reservation <b></h3><?php  echo  isset($result->Total) ? '<span style="color:red">(' .$result->Total . ')</span>' : '';?></a>


                 <?php 
                    }
                ?>

                <a class="<?php echo (currentpage() == 'mod_contact_us') ? "active" : false;?>list-group-item list-group-item-action bg-transparent fw-bold text-light"
                style=" background-color: #6d4330; border-top:2px solid white;  border-bottom: 2px solid white; border-radius: 2px" href="<?php echo WEB_ROOT; ?>admin/mod_contact_us/index.php" ><h3 id="h3"><b>Messages <b></h3></a>


                 
              
         

                 <a class="<?php echo (currentpage() == 'mod_reports') ? "active" : false;?>list-group-item list-group-item-action bg-transparent fw-bold text-light"
                style=" background-color: #6d4330; border-bottom: 2px solid white; border-top: 2px solid white; border-radius: 0px;" href="<?php echo WEB_ROOT; ?>admin/mod_reports/index.php"><h3 id="h3"><b>Reports<b></h3></a></a>
           

       
                <?php if($_SESSION['ADMIN_UROLE']=="Administrator"){ ?>

                <a class="<?php echo (currentpage() == 'mod_users') ? "active" : false;?>list-group-item list-group-item-action bg-transparent fw-bold text-light"
                style="background-color: #6d4330; border-top:2px solid white;  border-bottom: 2px solid white !important; border-radius: 0px" href="<?php echo WEB_ROOT; ?>admin/mod_users/index.php" ><h3 id="h3"><b>Users<b></h3></a>

                <?php } ?>
           
      
                  
            </br>
                       
                </div>
            </div>
       
            <!-- SIDEBAR ENDS HERE -->