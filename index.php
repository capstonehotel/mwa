<?php 
 require_once("initialize.php");
// Assuming you already have a connection to the database
// $conn = new mysqli("localhost", "username", "password", "database");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);
$sql =  "ALTER TABLE star_ratings MODIFY id INT NOT NULL AUTO_INCREMENT PRIMARY KEY";
$result = mysqli_query($conn, $sql);

if ($conn->query($sql) === TRUE) {
  echo "Column 'id' has been set to AUTO_INCREMENT successfully.";
} else {
  echo "Error updating column: " . $conn->error;
}



// require_once("includes/initialize.php");
$content='home.php';
$view = (isset($_GET['p']) && $_GET['p'] != '') ? $_GET['p'] : '';
$account = 'guest/update.php';
$small_nav = 'theme/small-navbar.php';
switch ($view) {

  case '1' :
        $title="Home";  
        $content='home.php';    
    break;
  case '2' :
      $title="Gallery"; 
    $content ='gallery.php';
    break;
  case '3' :
      $title="About Us";  
    $content = 'about.php';   
    break;

   case 'rooms' :
    $title="Rooms and Rates";  
    $content ='room_rates.php';    
    break;

  case 'contact' :
      $title="Contacts";  
    $content ='contact.php';    
    break;

  case 'about-us' :
      $title="About Us";  
    $content ='about_us.php';    
    break;

 case 'booking' :
      $title="Book A Room";  
    $content ='bookAroom.php';    
    break;
        
  case 'accomodation' :
      $title="Accomodation";  
      $content='accomodation.php';
    break;  

  case 'largeview' :
      // $title="View";  
    $content ='largeimg.php';
    break;
  default :
      $title="Home";  
    $content ='home.php';   
}

  include ('theme/template.php');
// Close the connection
$conn->close();

?>
 
