<?php 
require_once("../includes/config.php");
require_once("../includes/functions.php");
require_once("../includes/session.php");
require_once("../includes/user.php");
require_once("../includes/pagination.php");
require_once("../includes/paginsubject.php");
require_once("../includes/accomodation.php");
require_once("../includes/guest.php");
require_once("../includes/reserve.php"); 
require_once("../includes/setting.php");
require_once("../includes/database.php");

$guest = New Guest();
$res = $guest->single_guest($_SESSION['GUESTID']);
?>

<div class="container">
  <form class="form-horizontal" action="guest/update.php" method="post" onsubmit="return personalInfo()" name="personal">
    <div class="row">
      <div class="col-md-6">
        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">First Name:</label>
          <input name="name" type="text" value="<?php echo $res->G_FNAME; ?>" class="form-control" id="exampleFormControlInput1" placeholder="First Name">
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Last Name:</label>
          <input name="last" type="text" value="<?php echo $res->G_LNAME; ?>" class="form-control" id="exampleFormControlInput1" placeholder="Last Name">
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Gender:</label>
          <input name="gender" type="text" value="<?php echo $res->G_GENDER; ?>" class="form-control" id="exampleFormControlInput1" placeholder="Gender">
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">City:</label>
          <input name="city" type="text" value="<?php echo $res->G_CITY; ?>" class="form-control" id="exampleFormControlInput1" placeholder="City">
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Address:</label>
          <input name="address" type="text" value="<?php echo $res->G_ADDRESS; ?>" class="form-control" id="exampleFormControlInput1" placeholder="Address">
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Date of Birth:</label>
          <input type="text" name="dbirth" value="<?php echo date($res->DBIRTH); ?>" class="form-control" id="exampleFormControlInput1" placeholder="Date of Birth">
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Phone:</label>
          <input name="phone" type="text" value="<?php echo $res->G_PHONE; ?>" class="form-control" id="exampleFormControlInput1" placeholder="Phone">
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Nationality:</label>
          <input name="nationality" type="text" value="<?php echo $res->G_NATIONALITY; ?>" class="form-control" id="exampleFormControlInput1" placeholder="Nationality">
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Company:</label>
          <input name="nationality" type="text" value="<?php echo $res->G_COMPANY; ?>" class="form-control" id="exampleFormControlInput1" placeholder="Nationality">
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Address:</label>
          <input name="nationality" type="text" value="<?php echo $res->G_CADDRESS; ?>" class="form-control" id="exampleFormControlInput1" placeholder="Nationality">
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Zip Code:</label>
          <input name="nationality" type="text" value="<?php echo $res->ZIP; ?>" class="form-control" id="exampleFormControlInput1" placeholder="Nationality">
        </div>
      </div>
      <div class="col-12">
        <input name="submit" type="submit" value="Save" class="btn btn-primary" onclick="return personalInfo();"/>
      </div>
    </div>
  </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>


<script type="text/javascript">
 $('.date_pickerfrom').datetimepicker({
  format: 'mm/dd/yyyy',
   startDate : '01/01/2000', 
    language:  'en',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1, 
    startView: 2,
    minView: 2,
    forceParse: 0 

    });


$('.date_pickerto').datetimepicker({
  format: 'mm/dd/yyyy',
   startDate : '01/01/2000', 
    language:  'en',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1, 
    startView: 2,
    minView: 2,
    forceParse: 0   

    });



$(document).ready( function() {

    $('.gallery-item').hover( function() {
        $(this).find('.img-title').fadeIn(400);
    }, function() {
        $(this).find('.img-title').fadeOut(100);
    });
  
});



$('.dbirth').datetimepicker({
  format: 'mm/dd/yyyy',
   startDate : '01/01/1960', 
    language:  'en',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1, 
    startView: 2,
    minView: 2,
    forceParse: 0   

    });



  //Validates Personal Info
        function personalInfo(){
        var a=document.forms["personal"]["name"].value;
        var b=document.forms["personal"]["last"].value;
         var b1=document.forms["personal"]["gender"].value;
        var c=document.forms["personal"]["city"].value;
        var d=document.forms["personal"]["address"].value;
        var e=document.forms["personal"]["dbirth"].value;  
        var f=document.forms["personal"]["zip"].value; 
        var g=document.forms["personal"]["phone"].value;
        var h=document.forms["personal"]["username"].value;
        var i=document.forms["personal"]["password"].value;


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
         if (document.personal.condition.checked == false)
        {
        alert ('pls. agree the term and condition of this hotel');
        return false;
        }
        if ((a=="Firstname" || a=="") || (b=="lastname" || b=="") || (b1=="gender" || b1=="") (c=="City" || c=="") || (d=="address" || d=="") || (e=="dateofbirth" || e=="") || (f=="Zip" || f=="") || (g=="Phone" || g=="")|| (h=="username" || h=="") || (j=="password" || j==""))
          {
          alert("all field are required!");
          return false;
          }


   
        
        // else
        // {
        // return true;
        // }

        }
</script>
<script>
  $(document).ready(function() {
    $('#accountModal').on('show.bs.modal', function() {
      var modal = $(this);
      $.ajax({
        url: 'guest/profile.php',
        method: 'GET',
        success: function(data) {
          modal.find('.modal-body').html(data);
        },
        error: function() {
          modal.find('.modal-body').html('<p>An error occurred while loading the content.</p>');
        }
      });
    });
  });
</script>
          
