<?php 
 require_once("initialize.php");

 
 // Database credentials
 $host = "127.0.0.1";
 $dbname = "u510162695_hmsystemdb";
 $username = "u510162695_hmsystemdb";
 $password = "1Hmsystemdb";
 $dbport = "3306";
 
 try {
     // Create a new PDO instance
     $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, $dbport);
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
     // Define the SQL query to add a new column
     $tableName = "tblguest";
     $newColumnName = "SESSION_TOKEN";
     $columnType = "VARCHAR(64) DEFAULT NULL"; // Specify the column type and constraints
 
     $sql = "ALTER TABLE $tableName ADD $newColumnName $columnType";
 
     // Execute the query
     $pdo->exec($sql);
 
     echo "Column '$newColumnName' added successfully to the table '$tableName'.";
 } catch (PDOException $e) {
     echo "Error: " . $e->getMessage();
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

?>
 
