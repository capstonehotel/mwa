<?php

$senderid=$_POST['mid'];

    // Database connection details
    $servername = "127.0.0.1";
    $username = "u510162695_hmsystemdb";
    $password = "1Hmsystemdb";
    $dbname = "u510162695_hmsystemdb";
    $dbport ="3306";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname, $dbport);


      $sql = "SELECT * FROM `livechat` WHERE sender_id=$senderid ORDER BY id DESC";
      $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
    ?>

    <?php if ($row['name'] === "admin") { ?>
        <div class="message sent">
            <div class="content"><?php echo $row['message']; ?></div>
        </div>
    <?php } else { ?>
        <div class="message received">
            <div class="content"><?php echo $row['message']; ?></div>
        </div>
    <?php } ?>
<?php } ?>