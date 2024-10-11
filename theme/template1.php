<?php
if(isset($_POST['avail'])){
$_SESSION['from'] = $_POST['from'];
$_SESSION['to']  = $_POST['to'];
  redirect(WEB_ROOT. "index.php?page=5");
}
?>

<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head><script src="theme/assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.115.4">
    <link rel="stylesheet" type="text/css" href="fonts/css/font-awesome.min.css" />
    <title><?php echo isset($title) ? $title . ' | HM Hotel' : 'HM mini Hotel' ; ?></title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/navbars-offcanvas/">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen" />
    <link href="css/datepicker.css" rel="stylesheet" media="screen" />

     <link href="cccss/galery.css" rel="stylesheet" media="screen" />
    <link href="css/ekko-lightbox.css" rel="stylesheet" />


    <link href="/theme/assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <?php
        if (isset($_SESSION['monbela_cart'])){
            if (count($_SESSION['monbela_cart'])>0) { $cart = '
                <span class="carttxtactive"> '.count($_SESSION['monbela_cart']) .' </span>
                '; } } if (isset($_SESSION['activity'])){ if (is_array($_SESSION['activity']) && count($_SESSION['activity'])>0) { $activity = '
                <span class="carttxtactive"> '.count($_SESSION['activity']) .' </span>
                ';
            }
        }
    ?>

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
      }
      .bd-mode-toggle {
        z-index: 1500;
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="styles.css" rel="stylesheet">
  </head>
  <body >
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
      <symbol id="check2" viewBox="0 0 16 16">
        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
      </symbol>
      <symbol id="circle-half" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
      </symbol>
      <symbol id="moon-stars-fill" viewBox="0 0 16 16">
        <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
        <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/>
      </symbol>
      <symbol id="sun-fill" viewBox="0 0 16 16">
        <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
      </symbol>
    </svg>
  
<main>
  <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
      <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center"
              id="bd-theme"
              type="button"
              aria-expanded="false"
              data-bs-toggle="dropdown"
              aria-label="Toggle theme (auto)">
        <svg class="bi my-1 theme-icon-active" width="1em" height="1em"><use href="#circle-half"></use></svg>
        <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
      </button>
      <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
        <li>
          <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
            <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#sun-fill"></use></svg>
            Light
            <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
          </button>
        </li>
        <li>
          <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
            <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#moon-stars-fill"></use></svg>
            Dark
            <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
          </button>
        </li>
        <li>
          <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
            <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#circle-half"></use></svg>
            Auto
            <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
          </button>
        </li>
      </ul>
    </div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
    <div class="container-fluid">
      <a class="navbar-brand"><img src="./images/logo2.jpg" style="width: 40px; height: 40px; border-radius: 30px; margin-left: 2px;">  HM Hotel Reservation</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbar2Label">HM Hotel Reservation</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <?php
           $accomodation = New Accomodation();
           $cur = $accomodation->listOfaccomodation(); ?>
          <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link <?php if(!isset($_GET['p'])){echo "active";} ?>" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if(isset($_GET['p']) && $_GET['p'] == "rooms"){echo "active";} ?>" href="index.php?p=rooms">Room and Rates</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle <?php if(isset($_GET['p']) && $_GET['p'] == "accomodation"){echo "active";} ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Accomondation
              </a>
              <ul class="dropdown-menu">
                <?php  foreach ($cur as $result) { ?>
                    <li>
                        <a class="dropdown-item <?php if(isset($_GET['q']) && $_GET['q'] == $result->ACCOMODATION){echo "active";} ?>" href="index.php?p=accomodation&q=<?php echo $result->ACCOMODATION; ?>"><?php echo $result->ACCOMODATION; ?></a>
                    </li>
                <?php } ?>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if(isset($_GET['p']) && $_GET['p'] == "contact"){echo "active";} ?>" href="index.php?p=contact">Contact Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if(isset($_GET['p']) && $_GET['p'] == "about-us"){echo "active";} ?>" href="index.php?p=about-us">About us</a>
            </li>
          </ul>
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item" >
              <a class="nav-link active" data-toggle="tooltip" title="Booking Cart"  href="<?php echo WEB_ROOT.'booking/index.php';  ?>"><i class="fa fa-shopping-cart" style="display: flex; font-size: 25px;"><?php echo  isset($cart) ? $cart : '' ; ?>  </i> 
             </a>

            </li>

            
            <?php if (isset($_SESSION['GUESTID'])) {

             $sql = "SELECT count(*) as MSG FROM `tblpayment` WHERE STATUS<>'Pending'  AND  `MSGVIEW`=0 AND `GUESTID`=" . $_SESSION['GUESTID'];
             $mydb->setQuery($sql);
             $res =$mydb->executeQuery(); 

               $msgCnt = $mydb->fetch_array($res);
              ?>
              <li class="nav-item dropdown">
              <a class="nav-link active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-envelope-o" style="font-size: 20px;"></i>
                  <span class="label label-success"><?php echo $msgCnt['MSG'] ; ?></span>
                <i class="fa fa-caret-down fa-fw"></i> 
              </a>
                <ul class="dropdown-menu">
                    <li class="header">You have <?php echo $msgCnt['MSG'] ; ?> messages</li>
                    <?php 
                   $sql = "SELECT  *  FROM `tblpayment` WHERE STATUS<>'Pending' AND `MSGVIEW`=0 AND `GUESTID`=" . $_SESSION['GUESTID'];
                    $result = $connection->query($sql);
                       while ($row = $result->fetch_assoc()) {
                     ?>
                    <li>
                      <a target="_blank"  class="read dropdown-item" href="guest/readmessage.php?code=<?php echo  $row['CONFIRMATIONCODE']; ?>" data-toggle="lightbox"   data-id="<?php echo  $row['CONFIRMATIONCODE']; ?> " >
                        <div class="pull-left">
                          <img src="images/1607134500_avatar.jpg" style="width: 30px; height: 30px; border-radius: 50%;" alt="">
                        </div>
                        <h4>
                          Admin
                        </h4>
                        <p>Reservation is already <?php echo   $row['STATUS']; ?>.. </p> 
                      </a>
                    </li>
                    <?php } ?>
                  </ul>
            </li>
            
          <?php 
            $g = New Guest() ;
            $result = $g->single_guest($_SESSION['GUESTID']);

            ?>

          
                    <li class="nav-item dropdown">
                      <a class="nav-link active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                         <i class="fa fa-user fa-fw"></i><?php echo $_SESSION['name']. ' ' . $_SESSION['last']; ?> <i class="fa fa-caret-down fa-fw"></i> 
                      </a>
                      <ul class="dropdown-menu" style="width: 200px;">
                          
                    <li class="widget-user-header bg-yellow">
                      <div class="widget-user-image" style="padding-top: 20px; text-align: center;">
                        <img class="img-circle" style="cursor:pointer;width:80px;height:80px;padding:0; border-radius: 50%; text-align: center;"  data-target="#myModal" data-toggle="modal" src="<?php echo WEB_ROOT.'images/user_avatar/'.$result->G_AVATAR;  ?>" alt="User Avatar">
                      </div>
                      <h5 style="text-align: center;" class="widget-user-username"><?php echo $_SESSION['name']. ' ' . $_SESSION['last']; ?> </h5>
                    </li>
                   <li>
                        <a class="dropdown-item" style="color:#000;text-align:left;border-bottom:1px solid #fff;"
                    href="../guest/profile.php" data-toggle="lightbox" >Account</a>
                    </li>
                    <li><a class="dropdown-item" style="color:#000;text-align:left;border-bottom:1px solid #fff;" 
                href="../guest/bookinglist.php" data-toggle="lightbox">Bookings</a>
                    </li>
                    <li>
                        <a class="dropdown-item" style="color:#000;text-align:left;border-bottom:1px solid #fff;" href="<?php echo WEB_ROOT.'logout.php';  ?>">Logout </a>
                    </li>
                       
                </ul>
            </li>
 
          </li>

          <?php } ?>
           <a class="text-light my-auto text-decoration-none ms-lg-2" href="admin/login.php" style="color: whitesmoke;">
             <span class="d-lg-inline d-none">|</span> <span class="ms-lg-2"><i class="fa fa-sign-in"></i> Login-Admin</span></a> 
          </ul>
          <?php  
 // }
?>
        </div>
      </div>
    </div>
  </nav>
  

   <div class="modal fade" id="myModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">×</button>

                        <h4 class="modal-title" id="myModalLabel">Choose Image.</h4>
                    </div>

                    <form action="guest/update.php" enctype="multipart/form-data" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="rows">
                                    <div class="col-md-12">
                                        <div class="rows">
                                            <div class="col-md-8"><input name="MAX_FILE_SIZE" type="hidden" value="1000000" /> <input id="image" name="image" type="file" /></div>

                                            <div class="col-md-4"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer"><button class="btn btn-default" data-dismiss="modal" type="button">Close</button> <button class="btn btn-primary" name="savephoto" type="submit">Upload Photo</button></div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

  <div>
    <div class="bg-body-tertiary">
        <div class="col-sm-12 py-2 mx-auto" style="max-width: 1000px">
             <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img style="height: 400px"  src="images/high.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                  <img style="height: 400px"   src="images/high.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                  <img style="height: 400px"  src="images/high.jpg" class="d-block w-100" alt="...">
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
        </div>
    </div>
    <div class="bg-body-tertiary ">
        
      <div class="col-sm-12 py-2 mx-auto" style="max-width: 1000px">
        <?php 
            require_once $content;  
        ?>
    </div>
    </div>
  </div>

</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-vO/PBZMPgLgQTH9TFnX1hBc2HEGx6y9Wx8QTXhXnT9h2k8phDqPC3IMnCHvDq5xB" crossorigin="anonymous"></script>

 <script src="jquery/jquery.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- DataTables JavaScript -->
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.min.js"></script>

        <script type="text/javascript" src="js/bootstrap-datepicker.js" charset="UTF-8"></script>
        <script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
        <script type="text/javascript" src="js/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>
        <!-- Custom Theme JavaScript -->

        <script src="js/ekko-lightbox.js"></script>
        <script type="text/javascript" language="javascript" src="js/plugins.js"></script>
        <script type="text/javascript" language="javascript" src="js/html5.js"></script>
        <script type="text/javascript" language="javascript" src="js/retina.js"></script>
        <script type="text/javascript" language="javascript" src="js/global.js"></script>

        <script>
            // tooltip demo
            $(".tooltip-demo").tooltip({
                selector: "[data-toggle=tooltip]",
                container: "body",
            });

            // popover demo
            $("[data-toggle=popover]").popover();
        </script>

        <script type="text/javascript">
            $(".date_pickerfrom").datetimepicker({
                format: "mm/dd/yyyy",
                startDate: new Date(),
                language: "en",
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                minView: 2,
                forceParse: 0,
            });

            $(".date_pickerto").datetimepicker({
                format: "mm/dd/yyyy",
                startDate: "01/01/2000",
                language: "en",
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                minView: 2,
                forceParse: 0,
            });
            
            function updateDatePickerToStartDate() {
     var selectedDate = $('#date_pickerfrom').val();
     $('#date_pickerto').val(selectedDate); // Update the input field's value
     $("#date_pickerto").datetimepicker("setStartDate", selectedDate);
     $('#date_pickerto').datetimepicker('update'); // Update the datetimepicker display
   }
            

            $('#date_pickerfrom').on('change', updateDatePickerToStartDate);

   // Set the initial value of date_pickerto based on date_pickerfrom's value
   const initialDateFromValue = $('#date_pickerfrom').val();
   $('#date_pickerto').val(initialDateFromValue);
   $('#date_pickerto').datetimepicker('update');

            $(document).ready(function () {
                $(".gallery-item").hover(
                    function () {
                        $(this).find(".img-title").fadeIn(400);
                    },
                    function () {
                        $(this).find(".img-title").fadeOut(100);
                    }
                );
            });


            $(document).ready(function() {
    var maxDate = new Date();
    maxDate.setFullYear(maxDate.getFullYear() - 21);

    $(".dbirth").datetimepicker({
        format: "mm/dd/yyyy",
        endDate: maxDate,
        language: "en",
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0,
    });
});


            //Validates Personal Info
            function personalInfo() {
                var a = document.forms["personal"]["name"].value;
                var b = document.forms["personal"]["last"].value;
               var b1 = document.forms["personal"]["gender"].value; 
                var c = document.forms["personal"]["city"].value;
                var d = document.forms["personal"]["address"].value;
                var e = document.forms["personal"]["dbirth"].value;
                var f = document.forms["personal"]["zip"].value;
                var g = document.forms["personal"]["phone"].value;
                var h = document.forms["personal"]["username"].value;
                var i = document.forms["personal"]["password"].value;

                // var atpos=f.indexOf("@");
                // var dotpos=f.lastIndexOf(".");
                // if (atpos<1 || dotpos<atpos+2 || dotpos+2>=f.length)
                //   {
                //   alert("Not a valid e-mail address");
                //   return false;
                //   }
                // if( f != g ) {
                // alert("email does not match");
                //   return false;
                // }
                if (document.personal.condition.checked == false) {
                    alert("pls. agree the term and condition of this hotel");
                    return false;
                }
                if (
                    a == "Firstname" ||
                    a == "" ||
                    b == "lastname" ||
                    b == "" ||
                   b1 == "gender" ||
                    b1 == "" ||
                    c == "City" ||
                    c == "" ||
                    d == "address" ||
                    d == "" ||
                    e == "dateofbirth" ||
                    e == "" ||
                    f == "Zip" ||
                    f == "" ||
                    g == "Phone" ||
                    g == "" ||
                    h == "username" ||
                    h == "" ||
                    j == "password" ||
                    j == ""
                ) {
                    alert("all field are required!");
                    return false;
                }

                // else
                // {
                // return true;
                // }
            }
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!--/.container-->
        <script language="javascript" type="text/javascript">
            function OpenPopupCenter(pageURL, title, w, h) {
                var left = (screen.width - w) / 2;
                var top = (screen.height - h) / 4; // for 25% - devide by 4  |  for 33% - devide by 3
                var targetWin = window.open(pageURL, title, "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=" + w + ", height=" + h + ", top=" + top + ", left=" + left);
            }
        </script>
        
      </body>
</html>
