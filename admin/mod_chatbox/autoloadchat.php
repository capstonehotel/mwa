<?php
require_once '../../includes/initialize.php';
$senderid=$_POST['mid'];

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "hmsystemdb";


// $conn = new mysqli($servername, $username, $password, $dbname);
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);

      $sql = "SELECT * FROM `livechat` WHERE sender_id=$senderid ORDER BY id DESC";
      $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
    ?>

    <?php if ($row['user_name'] === "admin") { ?>
        <div class="message sent">
            <div class="content"><?php echo $row['message']; ?></div>
        </div>
    <?php } else { ?>
        <div class="message received">
            <div class="content"><?php echo $row['message']; ?></div>
        </div>
    <?php } ?>
<?php } ?>