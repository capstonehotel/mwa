<?php
require_once 'initialize.php';
$roomid = $_POST['roomid'];



// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "hmsystemdb";


// Create connection
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM star_ratings WHERE room_id = $roomid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {




  // output data of each row
  while($row = $result->fetch_assoc()) { ?>
<div class="review-item">
        <div class="review-header">
            <img src="images/user_avatar/<?php echo $row["user_image"]; ?>" alt="User1 Profile" class="profile-image">
            <div class="review-info">
                <strong><?php echo $row["user_name"]; ?></strong>
                <div class="star-rating">
                  <?php
                  $totalrating = $row["rating"];
                  for ($x = 1; $x <= $totalrating; $x++) {
                    echo '<span class="icon-star"><i class="fas fa-star"></i></span>';
                  } ?>
                    <span class="review-date"><?php echo $row["created_at"]; ?></span> <!-- Example date -->
                </div>
            </div>
        </div>
        <p class="review-text"><?php echo $row["comment"]; ?></p>
</div>
<?php
  }
} else {
  echo "No Reviews yet.";
}
$conn->close();
?>

