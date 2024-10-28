<?php

$roomid = $_POST['roomid'];



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hmsystemdb";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM star_ratings WHERE room_id = $roomid";


$resultrating = $conn->query($sql);
$count = 0;
$sumratings = 0;

$total1rating = 0;
$total2rating = 0;
$total3rating = 0;
$total4rating = 0;
$total5rating = 0;




if ($resultrating->num_rows > 0) {
  // output data of each row
  while($rowrating = $resultrating->fetch_assoc()) {
    $rating = $rowrating["rating"];
    $rcomment = $rowrating["comment"];
    $sumratings += $rowrating["rating"];
    $count++;

    if ($rating == "1") {
        $total1rating++;
    }

    if ($rating == "2") {
        $total2rating++;
    }

    if ($rating == "3") {
        $total3rating++;
    }

    if ($rating == "4") {
        $total4rating++;
    }

    if ($rating == "5") {
        $total5rating++;
    }

}

$totalrated = $count;
$totalrating = $sumratings/$totalrated;


$averageRating = $totalrating; // Calculated from user reviews
$totalReviews = $totalrated;
$ratingCounts = [
    5 => $total5rating,
    4 => $total4rating,
    3 => $total3rating,
    2 => $total2rating,
    1 => $total1rating
];
?>


                            <!-- Overall Average Rating -->
                            <div class="average-rating d-flex align-items-center mb-2">
                                <span class="stars mr-2">
                                    <?php
                                        // Display filled and empty stars based on average rating
                                        $fullStars = floor($averageRating);
                                        $halfStar = ($averageRating - $fullStars) >= 0.5 ? 1 : 0;
                                        $emptyStars = 5 - $fullStars - $halfStar;
                                        for ($i = 0; $i < $fullStars; $i++) {
                                            echo '<i class="fas fa-star text-warning"></i>';
                                        }
                                        if ($halfStar) {
                                            echo '<i class="fas fa-star-half-alt text-warning"></i>';
                                        }
                                        for ($i = 0; $i < $emptyStars; $i++) {
                                            echo '<i class="far fa-star text-warning"></i>';
                                        }
                                    ?>
                                </span>
                                <span class="average-rating-value mr-2"><?php echo number_format($averageRating, 1); ?> / 5</span>
                                <span class="total-reviews text-muted">(<?php echo $totalReviews; ?> Reviews)</span>
                            </div>

                            <!-- Rating Breakdown -->
                            <div class="rating-breakdown">
                                <?php foreach (array_reverse($ratingCounts, true) as $star => $count): 
                                    $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                                ?>
                                <div class="rating-row d-flex align-items-center mb-1">
    <span class="star-label mr-2 font-weight-bold" style="width: 30px;"><?php echo $star; ?></span>
    <div class="progress" style="width: 400px; height: 10px; margin-right: 10px;"> <!-- Set a fixed width -->
        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $percentage; ?>%;" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <span class="rating-count text-muted"><?php echo $count; ?></span>
</div>


                                <?php endforeach; ?>
                            </div>



<?php
} else { 

$averageRating = 0; // Calculated from user reviews
$totalReviews = 0;
$ratingCounts = [
    5 => 0,
    4 => 0,
    3 => 0,
    2 => 0,
    1 => 0
];

?>
                            <!-- Overall Average Rating -->
                            <div class="average-rating d-flex align-items-center mb-2">
                                <span class="stars mr-2">
                                    <?php
                                        // Display filled and empty stars based on average rating
                                        $fullStars = floor($averageRating);
                                        $halfStar = ($averageRating - $fullStars) >= 0.5 ? 1 : 0;
                                        $emptyStars = 5 - $fullStars - $halfStar;
                                        for ($i = 0; $i < $fullStars; $i++) {
                                            echo '<i class="fas fa-star text-warning"></i>';
                                        }
                                        if ($halfStar) {
                                            echo '<i class="fas fa-star-half-alt text-warning"></i>';
                                        }
                                        for ($i = 0; $i < $emptyStars; $i++) {
                                            echo '<i class="far fa-star text-warning"></i>';
                                        }
                                    ?>
                                </span>
                                <span class="average-rating-value mr-2"><?php echo number_format($averageRating, 1); ?> / 5</span>
                                <span class="total-reviews text-muted">(<?php echo $totalReviews; ?> Reviews)</span>
                            </div>

                            <!-- Rating Breakdown -->
                            <div class="rating-breakdown">
                                <?php foreach (array_reverse($ratingCounts, true) as $star => $count): 
                                    $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                                ?>
                                <div class="rating-row d-flex align-items-center mb-1">
    <span class="star-label mr-2 font-weight-bold" style="width: 30px;"><?php echo $star; ?></span>
    <div class="progress" style="width: 400px; height: 10px; margin-right: 10px;"> <!-- Set a fixed width -->
        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $percentage; ?>%;" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <span class="rating-count text-muted"><?php echo $count; ?></span>
</div>


                                <?php endforeach; ?>
                            </div>

<?php
}

$conn->close();
?>

