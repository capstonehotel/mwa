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

        <div class="menu-header">
            <span class="menu-title">Notifications</span>
            <a href="javascript:void(0)" class="clear-noti">Clear All</a>
        </div>
        <div class="menu-content">
            <!-- Notification with image and text -->
            <!-- <div class="menu-section">
                <ul class="notification-list">
                    <li class="notification-message">
                        <a href="/mcchmhotelreservation.com/admin/mod_reservation/index.php?viewed=bookings">
                        <div class="notification" style="display: flex; align-items: center;"> -->
                        <!-- Profile image -->
                        <!-- <img alt="" src="../../profile.jpg" class="avatar-img rounded-circle" style="margin-right: 10px; margin-bottom: 12px; height: 50px; width:50px;" />
                        <div class="content" style="font-size: 15px;">
                           -->
                            <!-- Message -->
                            <!-- <p style="margin: 0 0 2px 0;">
                                <strong><?php echo $_SESSION['name'] . ' ' . $_SESSION['last']; ?></strong> has made a booking <?php echo ['ROOM']; ?>
                            </p>
                            <p class="time" style="margin-bottom: 5px;">
                                11/22/2002
                            </p>
                        </div>
                    </div>
                        </a>
                    </li>
                </ul>
                <ul class="notification-list">
                    <li class="notification-message">
                        <a href="/mcchmhotelreservation.com/admin/mod_reservation/index.php?viewed=bookings">
                        <div class="notification" style="display: flex; align-items: center;"> -->
                        <!-- Profile image -->
                        <!-- <img alt="" src="../../profile.jpg" class="avatar-img rounded-circle" style="margin-right: 10px; margin-bottom: 12px; height: 50px; width:50px;" />
                        <div class="content" style="font-size: 15px;">
                           -->
                            <!-- Message -->
                            <!-- <p style="margin: 0 0 2px 0;">
                                <strong>Kath Ungon</strong> has made a booking of 112jhgkhkghgkgjkhgkjhgkhjkghgkjhj
                            </p>
                            <p class="time" style="margin-bottom: 5px;">
                                11/22/2002
                            </p>
                        </div>
                    </div>
                        </a>
                    </li>
                </ul>
                <ul class="notification-list">
                    <li class="notification-message">
                        <a href="/mcchmhotelreservation.com/admin/mod_reservation/index.php?viewed=bookings">
                        <div class="notification" style="display: flex; align-items: center;"> -->
                        <!-- Profile image -->
                        <!-- <img alt="" src="../../profile.jpg" class="avatar-img rounded-circle" style="margin-right: 10px; margin-bottom: 12px; height: 50px; width:50px;" />
                        <div class="content" style="font-size: 15px;"> -->
                          
                            <!-- Message -->
                            <!-- <p style="margin: 0 0 2px 0;">
                                <strong><?php echo $_SESSION['name'] . ' ' . $_SESSION['last']; ?></strong> has made a booking in roomggg  <?php echo  $result->ROOM.' '. $result->ROOMDESC; ?>
                            </p>
                            <p class="time" style="margin-bottom: 5px;">
                                11/22/2002
                            </p>
                        </div>
                    </div>
                        </a>
                    </li>
                </ul>
                <ul class="notification-list">
                    <li class="notification-message">
                        <a href="/mcchmhotelreservation.com/admin/mod_reservation/index.php?viewed=bookings">
                        <div class="notification" style="display: flex; align-items: center;"> -->
                        <!-- Profile image -->
                        <!-- <img alt="" src="../../profile.jpg" class="avatar-img rounded-circle" style="margin-right: 10px; margin-bottom: 12px; height: 50px; width:50px;" />
                        <div class="content" style="font-size: 15px;">
                           -->
                            <!-- Message -->
                            <!-- <p style="margin: 0 0 2px 0;">
                                <strong>Kath Ungon</strong> has made a booking of 112jhgkhkghgkgjkhgkjhgkhjkghgkjhj
                            </p>
                            <p class="time" style="margin-bottom: 5px;">
                                11/22/2002
                            </p>
                        </div>
                    </div>
                        </a>
                    </li>
                </ul>
            </div> -->
        
    <ul class="notification-list">
        <?php
        // Assuming you have fetched notifications into an array called $notifications
        foreach ($notifications as $notification) {
            $guestFirstName = $notification['G_FNAME'];
            $guestLastName = $notification['G_LNAME'];
            $room = $notification['ROOM'];
            $confirmationCode = $notification['CONFIRMATIONCODE'];
        ?>
            <li class="notification-message">
                <a href="/mcchmhotelreservation.com/admin/mod_reservation/index.php?viewed=bookings&code=<?php echo $confirmationCode; ?>">
                    <div class="notification" style="display: flex; align-items: center;">
                        <img alt="" src="../../profile.jpg" class="avatar-img rounded-circle" style="margin-right: 10px; margin-bottom: 12px; height: 50px; width:50px;" />
                        <div class="content" style="font-size: 15px;">
                            <p style="margin: 0 0 2px 0;">
                                <strong><?php echo $guestFirstName . ' ' . $guestLastName; ?></strong> has made a booking for room <?php echo $room; ?>
                            </p>
                            <p class="time" style="margin-bottom: 5px;">
                                <?php echo date('m/d/Y'); // Replace with actual date if available ?>
                            </p>
                        </div>
                    </div>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>
        </div>
        <!-- Footer with "View all Notifications" outside of scrollable content -->
        <div class="menu-footer" style="padding: 10px; text-align: center; border-top: 1px solid #eee;">
            <a href="https://mcchmhotelreservation.com/admin/mod_reservation/index.php?viewed=all">View all Notifications</a>
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
    display: none;
    position: absolute;
    top: 50px;
    right: -140px;
    width: 400px;
    max-height: 900px; /* Increased height */
    overflow-y: auto; /* Keep scrolling */
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000;
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

</script>