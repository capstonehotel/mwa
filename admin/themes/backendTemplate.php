<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo isset($title) ? $title . ' | HM_HotelReservation' :  'HM_HotelReservation' ; ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo WEB_ROOT; ?>/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo WEB_ROOT; ?>/admin/css/sb-admin-2.min.css" rel="stylesheet">

 <link href="<?php echo WEB_ROOT; ?>admin/assets/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href=".../assets/bootstrap/css/bootstrap.min.css">

<link href="<?php echo WEB_ROOT; ?>admin/css/dataTables.bootstrap.css" rel="stylesheet" media="screen">
<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT; ?>admin/css/jquery.dataTables.css">
<link href="<?php echo WEB_ROOT; ?>admin/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" language="javascript" src="<?php echo WEB_ROOT; ?>admin/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo WEB_ROOT; ?>admin/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo WEB_ROOT; ?>admin/js/bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo WEB_ROOT; ?>admin/js/bootstrap-modal.js"></script>
<script type="text/javascript" src="<?php echo WEB_ROOT; ?>admin/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo WEB_ROOT; ?>admin/js/locales/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>

</head>

<body id="page-top">
 
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion toggled" id="accordionSidebar" style="background: maroon">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo WEB_ROOT; ?>/admin/index.php">
                <div class="sidebar-brand-icon ">         
                 <img src="<?php echo WEB_ROOT; ?>/images/logo2.jpg" style="height:55px; width:55px; border-radius: 15px; margin-left: 2px;">
                </div>
                <div class="sidebar-brand-text mx-3"> HM Hotel Reservation</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo WEB_ROOT; ?>/admin/index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="<?php echo WEB_ROOT; ?>/admin/mod_room/index.php">
                    <i class="fas fa-fw fa-school"></i>
                    <span>Rooms</span></a>
            </li>
            
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo WEB_ROOT; ?>/admin/mod_accomodation/index.php">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Accomodation </a>
            </li>

           

                <?php
                $query = "SELECT count(*) as 'Total' FROM `tblpayment` WHERE `STATUS`='Pending'";
                $mydb->setQuery($query);
                $cur = $mydb->loadResultList();  
                foreach ($cur as $result) { 
                ?>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo WEB_ROOT; ?>admin/mod_reservation/index.php">
                    <i class="fas fa-fw fa-arrow-alt-circle-down"></i>
                    <span>Reservations</span></a>
            </li>
             <?php 
                    }
                ?>

            <li class="nav-item active">
                <a class="nav-link" href="<?php echo WEB_ROOT; ?>admin/mod_contact_us/index.php">
                    <i class="fas fa-fw fa-sms"></i>
                    <span>Messages</span></a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="<?php echo WEB_ROOT; ?>admin/mod_reports/index.php">
                    <i class="fas fa-fw fa-receipt"></i>
                    <span>Report</span></a>
            </li>
 <?php if($_SESSION['ADMIN_UROLE']=="Administrator"){ ?>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo WEB_ROOT; ?>admin/mod_users/index.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Users</span></a>
            </li>
   <?php } ?>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                  <ul class="navbar-nav ml-auto">


                  
            <?php
            ///   $conn = mysqli_connect('localhost', 'root', '', 'southgatedb');
              $id = $_SESSION['ADMIN_ID'];
              $sql = "SELECT * FROM `tbluseraccount` WHERE `USERID` = '$id'";
              $result = mysqli_query($connection, $sql);
             
              
            ?>
        
                <?php 
    $querys = "SELECT count(*) as 'Total' FROM `tblcontact` WHERE CONTID != '' ";
                $mydb->setQuery($querys);
                $cury = $mydb->loadResultList();  
                foreach ($cury as $resulta) { 
   ?>
   <li class="nav-item my-auto">
                 <a href="<?php echo WEB_ROOT; ?>/admin/mod_contact_us/index.php" class="text-dark"><i class="fa fa-envelope"></i> <?php  echo  isset($resulta->Total) ? $resulta->Total  : 0;?></a><span style="margin-left: 10px;">|</span></a>
  </li>
                  <?php } ?>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php
                      while($row = mysqli_fetch_assoc($result)){
                      echo $row['ROLE'];
                       ?></span>
                                <img class="img-profile rounded-circle"
                                    src="<?php echo WEB_ROOT; ?>/admin/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <?php if($_SESSION['ADMIN_UROLE']=="Administrator"){ ?>
                                <a class="dropdown-item" href="<?php echo WEB_ROOT; ?>admin/mod_users/index.php?view=edit&id=<?php echo $row['USERID']; ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                    <?php } ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
<?php } ?>
                    </ul>

                </nav>


                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Content Row -->
                    <div class="row">
                        <?php require_once $content;?>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Hotel Reservation 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo WEB_ROOT; ?>/admin/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo WEB_ROOT; ?>/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo WEB_ROOT; ?>/admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo WEB_ROOT; ?>/admin/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?php echo WEB_ROOT; ?>/admin/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?php echo WEB_ROOT; ?>/admin/js/demo/chart-area-demo.js"></script>
    <script src="<?php echo WEB_ROOT; ?>/admin/js/demo/chart-pie-demo.js"></script>
    <script src="<?php echo WEB_ROOT; ?>/admin/js/demo/datatables-demo.js"></script>

    <!-- Page level plugins -->
    <script src="<?php echo WEB_ROOT; ?>/admin/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo WEB_ROOT; ?>/admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    

</body>
<script type="text/javascript">
//execute if all html elemen has been completely loaded
$(document).ready(function(){

//specify class name of a specific element. click event listener--
$('.cls_btn').click(function(){
//access the id of the specific element that has been click 
var id = $(this).attr('id');
//to debug every value of element,variable, object ect...
console.log($(this).attr('id'));

//execute a php file without reloading the page and manipulate the php responce data
$.ajax({

  type: "POST",
  //the php file that contain a mysql query
  url: "some.php",
  //submit parameter
  data: { id:id,name:'angelo' }
})
//.done means will execute if the php file has done all the processing(ex: query)
  // .done(function( msg ) {
  //    //decode JSON from PHP file response
  //    var result = JSON.parse(msg);

  //    console.log(this);
    
  //    //apply the value to each element
  //   $('#display #infoid').html(result[0].member_id);
  //   $('#display #infoname').html(result[0].fName+" "+result[0].lName);
  //   $('#display #Email').html(result[0].email);
  //   $('#display #Gender').html(result[0].gender);
  //   $('#display #bday').html(result[0].bday);
  //     });

});

});
</script>
<script type="text/javascript" charset="utf-8">
  
$(document).on("click", ".get-id", function () {
   var p_id = $(this).data('id');
    $(".modal-body #infoid").val( p_id );
   
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('.toggle-modal').click(function(){
        $('#logout').modal('toggle');
    }); 
});
</script>
<script type="text/javascript">
$(document).ready(function(){
    $('.toggle-modal-reserve').click(function(){
        $('#reservation').modal('toggle');
    }); 
});

 


</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.roomImg').click(function(){
            var id = $(this).data('id');
            // alert(id)
     
              $.ajax({    //create an ajax request to load_page.php
                type:"POST",
                url: "editpic.php",             
                dataType: "text",   //expect html to be returned  
                data:{ROOMID:id},               
                success: function(data){                    
                   $('#myModal').modal('toggle').html(data); 
                    // alert(data);

                } 
            }); 
        }); 
});
</script>

<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
    var t = $('#example').DataTable( {
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 1
        } ], 
       "order": [[ 1, 'desc' ]]
    } );
 
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
} );

$(document).ready(function() {
    var t = $('#table').DataTable( {
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ], 
       "order": [[ 7, 'desc' ]]
    } );
 
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
} );
    </script>
<?php
 

 admin_logged_in();
?>

<script>

          function checkall(selector)
          {
            if(document.getElementById('chkall').checked==true)
            {
              var chkelement=document.getElementsByName(selector);
              for(var i=0;i<chkelement.length;i++)
              {
                chkelement.item(i).checked=true;
              }
            }
            else
            {
              var chkelement=document.getElementsByName(selector);
              for(var i=0;i<chkelement.length;i++)
              {
                chkelement.item(i).checked=false;
              }
            }
          }

          function checkNumber(textBox)
            {
                while (textBox.value.length > 0 && isNaN(textBox.value)) {
                    textBox.value = textBox.value.substring(0, textBox.value.length - 1)
                }
                textBox.value = trim(textBox.value);
            }
            //
            function checkText(textBox)
            {
                var alphaExp = /^[a-zA-Z]+$/;
                while (textBox.value.length > 0 && !textBox.value.match(alphaExp)) {
                    textBox.value = textBox.value.substring(0, textBox.value.length - 1)
                }
                textBox.value = trim(textBox.value);
            }
          </script>

           <script type="text/javascript">
    $('.start').datetimepicker({
        language:  'en',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('.end').datetimepicker({
        language:  'en',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
</script>
</html>

