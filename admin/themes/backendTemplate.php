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
    <link href="https://mcchmhotelreservation.com/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
        
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="https://mcchmhotelreservation.com/admin/css/sb-admin-2.min.css" rel="stylesheet">

 <link href="https://mcchmhotelreservation.com/admin/assets/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href=".../assets/bootstrap/css/bootstrap.min.css">

<link href="https://mcchmhotelreservation.com/admin/css/dataTables.bootstrap.css" rel="stylesheet" media="screen">
<link rel="stylesheet" type="text/css" href="https://mcchmhotelreservation.com/admin/css/jquery.dataTables.css">
<link href="https://mcchmhotelreservation.com/admin/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" language="javascript" src="https://mcchmhotelreservation.com/admin/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="https://mcchmhotelreservation.com/admin/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="https://mcchmhotelreservation.com/admin/js/bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" src="https://mcchmhotelreservation.com/admin/js/bootstrap-modal.js"></script>
<script type="text/javascript" src="https://mcchmhotelreservation.com/admin/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="https://mcchmhotelreservation.com/admin/js/locales/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>

</head>
<?php
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://trusted-scripts.com;");
header("X-Frame-Options: DENY");
header("Content-Security-Policy: frame-ancestors 'none';");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");


// Redirect all HTTP requests to HTTPS if not already using HTTPS
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
  header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
  exit();
}



// Secure session cookie settings
ini_set('session.cookie_secure', '1');    // Enforces HTTPS-only session cookies
ini_set('session.cookie_httponly', '1');  // Prevents JavaScript from accessing session cookies
ini_set('session.cookie_samesite', 'Strict'); // Prevents CSRF by limiting cross-site cookie usage


// Additional security headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");


// Anti-XXE: Secure XML parsing
libxml_disable_entity_loader(true); // Disable loading of external entities
libxml_use_internal_errors(true);   // Suppress libxml errors for better handling

function parseXMLSecurely($xmlString) {
    $dom = new DOMDocument();
    
    // Load the XML string securely
    if (!$dom->loadXML($xmlString, LIBXML_NOENT | LIBXML_DTDLOAD | LIBXML_DTDATTR | LIBXML_NOCDATA)) {
        throw new Exception('Error loading XML');
    }
    
    // Process the XML content safely
    return $dom;
}

// Example usage
try {
    $xmlString = '<root><element>Sample</element></root>'; // Replace with actual XML input
    $dom = parseXMLSecurely($xmlString);
    // Continue processing $dom...
} catch (Exception $e) {
    // Handle errors securely
    echo 'Error processing XML: ' . $e->getMessage();
}
?>

 <script type="text/javascript">
    // Disable right-click with an alert
    document.addEventListener('contextmenu', function(event) {
        event.preventDefault();
        //alert("Right-click is disabled on this page.");
    });

    // Disable F12 key and Inspect Element keyboard shortcuts with alerts
    document.onkeydown = function(e) {
        // F12
        if (e.key === "F12") {
           // alert("F12 (DevTools) is disabled.");
            e.preventDefault(); // Prevent default action
            return false;
        }

        // Ctrl + Shift + I (Inspect)
        if (e.ctrlKey && e.shiftKey && e.key === "I") {
            //alert("Inspect Element is disabled.");
            e.preventDefault();
            return false;
        }

        // Ctrl + Shift + J (Console)
        if (e.ctrlKey && e.shiftKey && e.key === "J") {
            //alert("Console is disabled.");
            e.preventDefault();
            return false;
        }


         // Ctrl + U or Ctrl + u (View Source)
         if (e.ctrlKey && (e.key === "U" || e.key === "u" || e.keyCode === 85)) {
            //alert("Viewing page source is disabled.");
            e.preventDefault();
            return false;
        }
    };
</script>

<script>
    (function() {
  const detectDevToolsAdvanced = () => {
    // Detect if the console is open by triggering a breakpoint
    const start = new Date();
    debugger; // This will trigger when dev tools are open
    const end = new Date();
    if (end - start > 100) {
      document.body.innerHTML = "<h1>Unauthorized Access</h1><p>Developer tools are not allowed on this page.</p>";
      document.body.style.textAlign = "center";
      document.body.style.paddingTop = "20%";
      document.body.style.backgroundColor = "#fff";
      document.body.style.color = "#000";
    }
  };

  setInterval(detectDevToolsAdvanced, 500); // Continuously monitor
})();


const blockedAgents = ["Cyberfox", "Kali"];
if (navigator.userAgent.includes(blockedAgents)) {
  document.body.innerHTML = "<h1>Access Denied</h1><p>Your browser is not supported.</p>";
}


if (window.__proto__.toString() !== "[object Window]") {
  //alert("Unauthorized modification detected.");
  window.location.href = "https://www.bible-knowledge.com/wp-content/uploads/battle-verses-against-demonic-attacks.jpg";
}

</script>
<?php
$disallowedUserAgents = [
    "BurpSuite", 
    "Cyberfox", 
    "OWASP ZAP", 
    "PostmanRuntime"
];

if (preg_match("/(" . implode("|", $disallowedUserAgents) . ")/i", $_SERVER['HTTP_USER_AGENT'])) {
    http_response_code(403);
    exit("Unauthorized access");
}
?> 

<body id="page-top">
 
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion toggled" id="accordionSidebar" style="background: maroon">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon ">         
                 <img src="https://mcchmhotelreservation.com/logo.jpg" style="height:55px; width:55px; border-radius: 15px; margin-left: 2px;">
                </div>
                <div class="sidebar-brand-text mx-3"> HM Hotel Reservation</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="https://mcchmhotelreservation.com/admin/index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="https://mcchmhotelreservation.com/admin/mod_room/index.php">
                    <i class="fas fa-fw fa-school"></i>
                    <span>Rooms</span></a>
            </li>
            
            <li class="nav-item active">
                <a class="nav-link" href="https://mcchmhotelreservation.com/admin/mod_accomodation/index.php">
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
                <a class="nav-link" href="https://mcchmhotelreservation.com/admin/mod_reservation/index.php">
                    <i class="fas fa-fw fa-arrow-alt-circle-down"></i>
                    <span>Reservations</span></a>
            </li>
             <?php 
                    }
                ?>
                 <li class="nav-item active">
                <a class="nav-link" href="https://mcchmhotelreservation.com/admin/mod_payment/index.php">
                <i class="fas fa-fw fa-money-bill"></i>
                    <span>Payment</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="https://mcchmhotelreservation.com/admin/mod_chatbox/index.php">
                <i class="fas fa-fw fa-comments"></i>
                    <span>Chatbox</a>
            </li>



            <!-- <li class="nav-item active">
                <a class="nav-link" href="https://mcchmhotelreservation.com/admin/mod_contact_us/index.php">
                    <i class="fas fa-fw fa-sms"></i>
                    <span>Messages</span></a>
            </li> -->

            <li class="nav-item active">
                <a class="nav-link" href="https://mcchmhotelreservation.com/admin/mod_reports/index.php">
                    <i class="fas fa-fw fa-receipt"></i>
                    <span>Report</span></a>
            </li>
 <!-- <?php if($_SESSION['ADMIN_UROLE']=="Administrator"){ ?>
            <li class="nav-item active">
                <a class="nav-link" href="https://mcchmhotelreservation.com/admin/mod_users/index.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Users</span></a>
            </li>
   <?php } ?> -->
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
              $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);
              $id = $_SESSION['ADMIN_ID'];
              $sql = "SELECT * FROM `tbluseraccount` WHERE `USERID` = '$id'";
              $result = mysqli_query($conn, $sql);

              $count_mess = $conn->query("SELECT COUNT(*) FROM tblcontact");
              $cnt_message = $count_mess->fetch_array();
            ?>
            <!-- <li class="nav-item my-auto">
                <a href="/HM_HotelReservation/admin/mod_contact_us/index.php" class="text-dark"><i class="fa fa-envelope"></i> <?php echo $cnt_message[0] ?></a> <span style="margin-left: 10px;">|</span>
            </li> -->
            <?php 
    $querysi = "SELECT count(*) as 'Total' FROM tblreservation WHERE DATE(TRANSDATE) = CURDATE()";
    $mydb->setQuery($querysi);
    $curya = $mydb->loadResultList();  
    $todayBookings = isset($curya[0]->Total) ? $curya[0]->Total : 0;
?>

<?php
//Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}



// Check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the admin ID from the session
$id = $_SESSION['ADMIN_ID'];

// Handle message notification viewing
if (isset($_GET['viewed']) && $_GET['viewed'] === 'messages') {
    $updateMessagesQuery = "UPDATE tblcontact SET is_read = 1 WHERE is_read = 0";
    mysqli_query($conn, $updateMessagesQuery);
}

// Handle booking notification viewing
if (isset($_GET['viewed']) && $_GET['viewed'] === 'bookings') {
    $updateBookingsQuery = "UPDATE tblreservation SET is_read = 1 WHERE is_read = 0 AND DATE(TRANSDATE) = CURDATE()";
    mysqli_query($conn, $updateBookingsQuery);
}

// Count unread messages
$count_messages_query = $conn->query("SELECT COUNT(*) FROM tblcontact WHERE is_read = 0");
$cnt_message = $count_messages_query->fetch_array();

$count_notifications_query = $conn->query("SELECT COUNT(*) FROM notifications WHERE IS_READ = 0");
$cnt_notifications = $count_notifications_query->fetch_array();

// Count today's unread bookings
$count_bookings_query = $conn->query("SELECT COUNT(*) FROM tblreservation WHERE is_read = 0 AND DATE(TRANSDATE) = CURDATE()");
$today_bookings = $count_bookings_query->fetch_array();

// Calculate total notifications
$total_notifications = $cnt_notifications[0];

// Close the database connection
mysqli_close($conn);
?>


<style>
.notification-badge {
    position: absolute;
    top: -10px;
    right: 3px;
    font-size: 0.65rem; /* Adjust font size of the badge */
    padding: 3px 6px;
    border-radius: 50%;
}
/* .notification {
    display: flex;
    align-items: center;
} */

.notification-img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
}


.time {
    font-size: 0.8em;
    color: gray;
}

</style>
<script>
    document.getElementById('chat-button').addEventListener('click', function() {
        document.getElementById('chatbox').classList.add('open');
        loadMessages();
    });

    function closeChatbox() {
        document.getElementById('chatbox').classList.remove('open');
    }

    function loadMessages() {
        fetch('chatbox?action=load')
            .then(response => response.json())
            .then(data => {
                const chatMessages = document.getElementById('chat-messages');
                chatMessages.innerHTML = '';
                data.forEach(message => {
                    const messageElement = document.createElement('div');
                    messageElement.textContent = message.message;
                    messageElement.classList.add('message', message.user_type === 'guest' ? 'received' : 'sent');
                    chatMessages.appendChild(messageElement);
                });
                chatMessages.scrollTop = chatMessages.scrollHeight;
            });
    }

    function sendMessage() {
        const messageInput = document.getElementById('message-input');
        const message = messageInput.value.trim();

        if (message !== '') {
            fetch('chatbox', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `message=${message}&user_type=admin`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const chatMessages = document.getElementById('chat-messages');
                    const messageElement = document.createElement('div');
                    messageElement.textContent = message;
                    messageElement.classList.add('message', 'sent');
                    chatMessages.appendChild(messageElement);
                    messageInput.value = '';
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            });
        }
    }

    setInterval(() => {
        fetch('chatbox?action=get_unread')
            .then(response => response.json())
            .then(data => {
                if (data.unread_count > 0) {
                    document.getElementById('chat-button').classList.add('has-unread');
                } else {
                    document.getElementById('chat-button').classList.remove('has-unread');
                }
            });
    }, 5000);
</script>
<?php 

?>
<li class="nav-item my-auto" style="position: relative;">
    <a href="javascript:void(0);" class="text-dark" id="bookingNotification" onclick="toggleNotificationMenu(event)">
        <i class="fa fa-bell"></i>
        <?php if ($total_notifications > 0): ?>
            <span class="badge badge-pill badge-danger notification-badge"><?php echo $total_notifications; ?></span>
        <?php endif; ?>
    </a>
    
     <!-- Notification menu -->
     <div id="notificationMenu" class="notification-menu" style="display: none;">
        <div class="menu-header">
            <span class="menu-title">Notifications</span>
            <a href="https://mcchmhotelreservation.com/admin/themes/clearallnotif.php" class="clear-noti">Clear All</a>
        </div>
        <div class="menu-content">
            <div class="menu-section">
                <ul class="notification-list">
                <?php
                // Set the default timezone to Manila
// date_default_timezone_set('Asia/Manila');
                // Function to calculate relative time
                function time_elapsed_string($datetime, $full = false) {
                    $now = new DateTime('now', new DateTimeZone('Asia/Manila')); // Current time with timezone
                    $ago = new DateTime($datetime, new DateTimeZone('Asia/Manila')); // Notification time with timezone
    $diff = $now->diff($ago); // Calculate difference

    // Time units
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    // Time strings
    $string = [
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    ];
    
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : ''); // Pluralize if needed
        } else {
            unset($string[$k]);
        }
    }

    // Return the first non-zero time string, or "just now"
    if (!$full) {
        $string = array_slice($string, 0, 1);
    }

    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
                // Fetch notifications with room details
                $notifications_query = "SELECT  `G_AVATAR`, `G_FNAME`, `G_LNAME`, `TRANSDATE`, `CONFIRMATIONCODE`, `n`.`ROOMID`, `AMOUNT_PAID`, `PAYMENT_STATUS`, `IS_READ`, `rm`.`ROOM` AS room_name, `rm`.`ROOMDESC` AS room_desc
                FROM `notifications` n 
                JOIN `tblguest` g ON n.`GUESTID` = g.`GUESTID` 
                JOIN `tblroom` rm ON n.`ROOMID` = rm.`ROOMID` 
                ORDER BY n.`TRANSDATE` DESC"; // Adjust limit as needed

                $notifications_result = mysqli_query($connection, $notifications_query);
                if ($notifications_result) {
                    while ($notification = mysqli_fetch_assoc($notifications_result)) {
                        $avatar = htmlspecialchars($notification['G_AVATAR']);
                        $fullName = htmlspecialchars($notification['G_FNAME'] . ' ' . $notification['G_LNAME']);
                        $roomName = htmlspecialchars($notification['room_name']);
                        $roomDesc = htmlspecialchars($notification['room_desc']);
                        $bookDate = time_elapsed_string($notification['TRANSDATE']);
                        $exactDate = date_format(date_create($notification['TRANSDATE']), 'h:i A'); // Format the exact date and time
                        $paidstatus = htmlspecialchars($notification['PAYMENT_STATUS']);
                        $paid = (float) $notification['AMOUNT_PAID'];
                        $readClass = $notification['IS_READ'] ? 'read' : 'unread'; 
                        ?>
                        <li class="notification-message <?php echo $readClass; ?>" >
                        <a href="../mod_reservation/index.php?view=view&code=<?php echo $row['CONFIRMATIONCODE']; ?>" onclick="markAsRead()">
        <div class="notification" style="display: flex; align-items: center;">
            <img alt="" src="../../images/user_avatar/<?php echo $avatar; ?>" class="avatar-img rounded-circle" style="height: 50px; width: 50px; border-radius: 50%; object-fit: cover; margin-right: 10px;" />
            <div class="content" style="font-size: 15px;">
                <p style="margin: 0 0 2px 0;">
                    <strong><?php echo $fullName; ?></strong> has made a booking in <strong><?php echo $roomName; ?></strong> (<?php echo $roomDesc; ?>) and <?php echo $paidstatus; ?> ₱ <?php echo $paid; ?> pesos.
                </p>
                <p class="time" style="margin-bottom: 5px;" title="<?php echo $exactDate; ?>">
                     <?php echo $exactDate; ?>
                </p>
            </div>
        </div>
    </a>
                        </li>
                            <?php
                        }
                    } else {
                        echo "<li class='notification-message'>No notifications available.</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-- Footer with "View all Notifications" outside of scrollable content -->
        <div class="menu-footer" style="padding: 10px; text-align: center; border-top: 1px solid #eee;">
            <a href="https://mcchmhotelreservation.com/admin/mod_reservation/index.php">View all Notifications</a>
        </div>
    </div>
    <span style="margin-left: 10px;">|</span>
</li>




<style>
    /* Media Queries for Mobile Responsiveness */
@media (max-width: 768px) {
    .notification-menu {
        right: 0; /* Align to the left on mobile */
        width: 100%; /* Full width */
    }
    .menu-title {
        font-size: 1rem; /* Ensure titles are readable */
    }
    .notification-img {
        width: 35px; /* Adjust image size for mobile */
        height: 35px;
    }
    .time {
        font-size: 0.7em; /* Smaller time font */
    }
    .notification-message {
        padding: 10px; /* Increased padding for touch targets */
    }
}

 .notification-menu {
    position: absolute; /* Position it relative to the parent */
    right: 0; /* Align to the right */
    top: 100%; /* Position below the button */
    width: 400px; /* Set a default width for larger screens */
    max-width: 90vw; /* Maximum width of 90% of the viewport width */
    max-height: 400px; /* Set a maximum height */
    overflow-y: auto; /* Enable vertical scrolling if content exceeds max height */
    background-color: white; /* Background color */
    border: 1px solid #ddd; /* Border for better visibility */
    border-radius: 5px; /* Rounded corners */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    z-index: 1000; /* Ensure it appears above other elements */
}

@media (max-width: 768px) {
    .notification-menu {
        width: 80vw; /* Adjust width for smaller screens */
        max-height: 70vh; /* Adjust max height for smaller screens */
    }
}

.menu-content {
    padding: 10px;
    max-height: 300px; /* Match the max-height of the notification menu */
    overflow-y: auto; /* Ensure scrolling is enabled */
}

.menu-section {
    margin-bottom: 7px;
}

.notification-message {
    padding-top: 8px;
    border-bottom: 1px solid #eee;
    padding-bottom: 8px; /* Added padding for better spacing */
}

.menu-header {
    padding: 10px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.menu-title {
    font-weight: bold;
    font-size: 16px;
}

.clear-noti {
    font-size: 12px;
    color: #007bff;
    cursor: pointer;
}



.notification-list {
    list-style-type: none;
    padding: 0;
    margin: 0;
}



.notification-message a {
    display: block;
    color: #333;
    text-decoration: none;
}

.notification-time {
    font-size: 12px;
    color: #999;
    display: block;
    margin-top: 5px;
}

.menu-footer {
    padding: 10px;
    text-align: center;
    border-top: 1px solid #eee;
}

.menu-footer a {
    font-size: 14px;
    color: #007bff;
}

</style>
<script>
   function toggleNotificationMenu() {
    var menu = document.getElementById("notificationMenu");
    if (menu.style.display === "block") {
        menu.style.display = "none";
        localStorage.setItem('notificationMenuOpen', 'false'); // Save state as closed
    } else {
        menu.style.display = "block";
        localStorage.setItem('notificationMenuOpen', 'true'); // Save state as open
    }
}


$(document).ready(function() {
        // Check the stored state of the notification menu
        var menuState = localStorage.getItem('notificationMenuOpen');
        var menu = document.getElementById("notificationMenu");
        
        if (menuState === 'true') {
            menu.style.display = "block"; // Show the menu if it was previously open
        } else {
            menu.style.display = "none"; // Hide the menu if it was previously closed
        }
    });
</script>
<script>
    document.getElementById('chat-button').addEventListener('click', function() {
        document.getElementById('chatbox').classList.add('open');
        loadMessages();
    });

    function closeChatbox() {
        document.getElementById('chatbox').classList.remove('open');
    }

    function loadMessages() {
        fetch('chatbox.php?action=load')
            .then(response => response.json())
            .then(data => {
                const chatMessages = document.getElementById('chat-messages');
                chatMessages.innerHTML = '';
                data.forEach(message => {
                    const messageElement = document.createElement('div');
                    messageElement.textContent = message.message;
                    messageElement.classList.add('message', message.user_type === 'guest' ? 'received' : 'sent');
                    chatMessages.appendChild(messageElement);
                });
                chatMessages.scrollTop = chatMessages.scrollHeight;
            });
    }

    function sendMessage() {
        const messageInput = document.getElementById('message-input');
        const message = messageInput.value.trim();

        if (message !== '') {
            fetch('chatbox.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `message=${message}&user_type=admin`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const chatMessages = document.getElementById('chat-messages');
                    const messageElement = document.createElement('div');
                    messageElement.textContent = message;
                    messageElement.classList.add('message', 'sent');
                    chatMessages.appendChild(messageElement);
                    messageInput.value = '';
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            });
        }
    }

    setInterval(() => {
        fetch('chatbox.php?action=get_unread')
            .then(response => response.json())
            .then(data => {
                if (data.unread_count > 0) {
                    document.getElementById('chat-button').classList.add('has-unread');
                } else {
                    document.getElementById('chat-button').classList.remove('has-unread');
                }
            });
    }, 5000);
</script>
<!-- <script>
    function toggleNotificationMenu() {
    var menu = document.getElementById("notificationMenu");
    if (menu.style.display === "block") {
        menu.style.display = "none";
    } else {
        menu.style.display = "block";
    }
}

// Close the menu when clicking outside
document.addEventListener('click', function(event) {
    var menu = document.getElementById("notificationMenu");
    var bellIcon = document.getElementById("bookingNotification");
    
    if (!menu.contains(event.target) && !bellIcon.contains(event.target)) {
        menu.style.display = "none";
    }
});
function markAsRead(reserveId, redirectUrl) {
    // Make an AJAX request to update the read status
    fetch('update_notification.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: reserveId }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Change the CSS class to 'read'
            const notificationElement = document.querySelector(`.notification-message[data-id="${reserveId}"]`);
            if (notificationElement) {
                notificationElement.classList.remove('unread');
                notificationElement.classList.add('read');
            }
            // Redirect to the specified URL
            window.location.href = redirectUrl;
        } else {
            console.error('Error updating notification status:', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

</script> -->
<?php
/// Update session variables based on the URL parameters
// if (isset($_GET['viewed'])) {
//     if ($_GET['viewed'] == 'messages') {
//         $_SESSION['message_notification_viewed'] = true;
//     }

//     if ($_GET['viewed'] == 'bookings') {
//         $_SESSION['booking_notification_viewed'] = true;
//     }
// }
?>
<?php
// $conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     // Mark the booking notification as new
//     $_SESSION['booking_notification_viewed'] = false;
//     $response = array('success' => true);
//     echo json_encode($response);
// }
?>



                 
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php
                      while($row = mysqli_fetch_assoc($result)){
                      echo $row['ROLE'];
                       ?></span>
                                <img class="img-profile rounded-circle"
                                    src="https://mcchmhotelreservation.com/admin/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <?php if($_SESSION['ADMIN_UROLE']=="Administrator"){ ?>
                                <a class="dropdown-item" href="https://mcchmhotelreservation.com/admin/mod_users/index.php?view=edit&id=<?php echo $row['USERID']; ?>">
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
                        <?php 
                        session_start();
                        $globalToken = file_get_contents('global_admin_token.txt');
 if (!isset($_SESSION['ADMIN_ID']) || !isset($_SESSION['admin_token']) || $_SESSION['admin_token'] !== $globalToken) {
	 // Token mismatch; logout the session
	 session_destroy();
	 echo "<script>alert('test');</script>";
	 header('Location: login.php');
	 exit();
 }
                        require_once $content;?>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <!-- <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Hotel Reservation 2023</span>
                    </div>
                </div>
            </footer> -->
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
                <div class="modal-body">Are you sure you want to logout?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="https://mcchmhotelreservation.com/admin/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="https://mcchmhotelreservation.com/admin/vendor/jquery/jquery.min.js"></script>
    <script src="https://mcchmhotelreservation.com/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="https://mcchmhotelreservation.com/admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="https://mcchmhotelreservation.com/admin/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="https://mcchmhotelreservation.com/admin/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="https://mcchmhotelreservation.com/admin/js/demo/chart-area-demo.js"></script>
    <script src="https://mcchmhotelreservation.com/admin/js/demo/chart-pie-demo.js"></script>
    <script src="https://mcchmhotelreservation.com/admin/js/demo/datatables-demo.js"></script>

    <!-- Page level plugins -->
    <script src="https://mcchmhotelreservation.com/admin/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="https://mcchmhotelreservation.com/admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>


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

