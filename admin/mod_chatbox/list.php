<link href="chat.css" rel="stylesheet">
<style>
   /* Three dots styling */
.three-dots {
    cursor: pointer;
    display: inline-block;
}
.dot {
    width: 5px;
    height: 5px;
    background-color: black;
    border-radius: 50%;
    margin: 2px;
}

/* Dropdown menu styling */
.dropdown-menu {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 100px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    padding: 10px;
    /* z-index: 1; */
    z-index: 9999;
}
.dropdown-menu a {
    color: black;
    padding: 8px 16px;
    text-decoration: none;
    display: block;
    text-align: right;
}
.dropdown-menu a:hover {
    background-color: #f1f1f1;
}

</style>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="row">
        <div class="left-chats">
            <div class="header">
                Chat with Guest
            </div>
            <div class="search">
                    <input id="searchInput" placeholder="Search" type="text"/>
                    
                </div>
            <div class="chats">
            
                <div class="chat-list-group ">
                <div id="noResultsMessage" style="display: none; color: gray; text-align: center;">
        No name exist.
    </div>
                <?php 
                       $sql = "SELECT g.G_AVATAR, l.* FROM `livechat` l 
                       JOIN `tblguest` g ON l.sender_id = g. GUESTID
                       GROUP BY l.sender_id";
                      $result = $connection->query($sql);
                        while ($row = $result->fetch_assoc()) {


                            $badgesql = "SELECT  *  FROM `livechat` WHERE status=0 AND sender_id=".$row['sender_id'];
                            $badgeresult = $connection->query($badgesql);
                            $count = 0;
                            while ($rowbadge = $badgeresult->fetch_assoc()) {
                                $count++;
                            }
                            $badge = $count;


                    ?>
                      <a href="<?php echo '?id='.$row['sender_id']; ?>" class="list-group-item list-group-item-action" style="border-left:0px; border-right:0px;">
            <img src="../../images/user_avatar/<?php echo $row['G_AVATAR']; ?>" alt="<?php echo $row['user_name']; ?>'s avatar" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
            <?php echo $row['user_name']; ?> 
            <?php if ($badge > 0) { ?>
            <span class="badge badge-pill badge-danger"><?php echo $badge; ?></span>
        <?php } ?>
    </a>
                    <?php } ?>

</div>
            </div>
        </div>
        <?php 
// Assuming you have already established a database connection

// Check if an ID is set in the URL
if (isset($_GET['id'])) {
    $sender_id = $_GET['id'];

    // SQL query to get the user's name and avatar based on sender_id
    $userSql = "SELECT g.G_AVATAR, l.user_name FROM `livechat` l 
                JOIN `tblguest` g ON l.sender_id = g. GUESTID 
                WHERE l.sender_id = $sender_id LIMIT 1";
    $userResult = $connection->query($userSql);
    
    // Fetch user details
    if ($userRow = $userResult->fetch_assoc()) {
        $userAvatar = $userRow['G_AVATAR'];
        $userName = $userRow['user_name'];
    } else {
        $userAvatar = 'undraw_profile.svg'; // Fallback avatar
        $userName = ''; // Fallback name
    }
} else {
    $userAvatar = 'undraw_profile.svg'; // Fallback avatar
    $userName = ''; // Fallback name
}
?>
        <div class="main">
        <div class="header" style="position: relative;">
        <img src="../../images/user_avatar/<?php echo $userAvatar; ?>" alt="<?php echo $userName; ?>'s avatar" style="width: 50px; height: 50px; border-radius: 50%;">
        <div class="name"><?php echo $userName; ?></div>
         <!-- Three Dots Menu -->
         <div class="three-dots" onclick="toggleMenu(event)">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
        <div class="dropdown-items unique-dropdown" id="uniqueDropdownItems" style="display: none; position: absolute; right: 10px; top: 50px; z-index: 9999;">
        <?php if (isset($_GET['id'])) { ?>
            <a href="markallasread.?id=<?php echo $_GET['id']; ?>" class="dropdown-item" style="display: block; padding: 8px 10px; background-color: #f9f9f9; color: #007bff; border: 1px solid #ddd; border-radius: 3px; text-decoration: none; margin-bottom: 5px;">
                Mark all as read
            </a>
        <?php } ?>
    </div>
        
        <!-- <?php if (isset($_GET['id'])) { ?>
            <a href="markallasread.php?id=<?php echo $_GET['id']; ?>" class="readall">Mark all as read</a>
        <?php } ?> -->
            </div>
            <div class="chat-messages">
                        <h3>Select User's</h3>
                    </div>
            <div class="chat-area">
        
                <!-- More messages... -->
            </div>
            <div class="input-area message-form">
                <input type="text"  id="adminmessage"  placeholder="Type a message...">
                <button class="send-button"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
    </div>
        </div>
        </div>
    </div>
</div>
<script>
 document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("searchInput");
    const listGroupItems = document.querySelectorAll('.list-group-item'); // Select all list group items
    const noResultsMessage = document.getElementById("noResultsMessage"); // Get the no results message element

    // Add an event listener to the search input
    searchInput.addEventListener('keyup', function() {
        const searchTerm = searchInput.value.toLowerCase(); // Get the search term and convert to lowercase
        let hasVisibleItems = false; // Flag to check if any items are visible

        // Loop through each list group item
        listGroupItems.forEach(item => {
            const name = item.textContent.toLowerCase(); // Get the full text content of the item

            // Check if the name includes the search term
            if (name.includes(searchTerm)) {
                item.style.display = ""; // Show the list group item
                hasVisibleItems = true; // Mark that we have at least one visible item
            } else {
                item.style.display = "none"; // Hide the list group item
            }
        });

        // Show or hide the no results message based on visibility of items
        if (hasVisibleItems) {
            noResultsMessage.style.display = "none"; // Hide the no results message
        } else {
            noResultsMessage.style.display = "block"; // Show the no results message
        }
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const leftChats = document.querySelector(".left-chats");
    const mainChat = document.querySelector(".main");
    let isChatOpen = false; // Track if chat is open

    // Create a close button for the main chat area
    const closeButton = document.createElement("button");
    closeButton.innerHTML = ' <span class="material-symbols-outlined">close</span>'; // Use Font Awesome icon for close
    closeButton.classList.add("close-button"); // Add class for styling
    closeButton.style.position = "absolute";
    closeButton.style.top = "5px";
    closeButton.style.right = "10px";
    closeButton.style.zIndex = "1000"; // Ensure it's above other content
    closeButton.style.backgroundColor = "transparent"; // No background
    closeButton.style.color = "gray"; // Icon color
    closeButton.style.border = "none"; // Remove default border
    closeButton.style.padding = "0"; // No padding
    closeButton.style.cursor = "pointer"; // Pointer cursor
    closeButton.style.fontSize = "20px"; // Icon size

    // Add event listener to the close button
    closeButton.addEventListener("click", function() {
        mainChat.classList.remove("active"); // Hide main chat
        leftChats.classList.remove("active"); // Reset left chats state
        isChatOpen = false; // Mark chat as closed
    });

    // Append the close button to the main chat area
    mainChat.appendChild(closeButton);

    // Function to open the chat
    function openChat() {
        leftChats.classList.add('active'); // Slide left chats out
        mainChat.classList.add('active'); // Slide main chat in
        isChatOpen = true; // Mark chat as open
    }

    // Event listeners for chat items
    document.querySelectorAll('.list-group-item').forEach(item => {
        item.addEventListener('click', function(event) {
            if (window.innerWidth > 768) { // Assuming 768px is the breakpoint for larger screens
                // On larger screens, directly navigate to the link
                window.location.href = this.href;
            } else {
                // On smaller screens, prevent default and open chat
                event.preventDefault(); // Prevent the default link behavior
                openChat(); // Open the main chat
            }
        });
    });
});
</script>


<script>
    // Wait until the DOM is fully loaded

document.addEventListener("DOMContentLoaded", function() {

    // Get the necessary elements
    const messageForm = document.querySelector(".message-form");
    const messageInput = messageForm.querySelector("input");
    const messageSendButton = messageForm.querySelector("button");
    const chatMessages = document.querySelector(".chat-messages");

    

    // Function to add a new message to the chat
    function addMessage(content, isSent) {
        // Create message container
        const messageDiv = document.createElement("div");
        messageDiv.classList.add("message");
        if (isSent) {
            messageDiv.classList.add("sent");
        }

        // Create content bubble
        const contentDiv = document.createElement("div");
        contentDiv.classList.add("content");
        contentDiv.textContent = content;

        // Append content to message container
        messageDiv.appendChild(contentDiv);

        // Append message to chat messages
        chatMessages.appendChild(messageDiv);

        
        // Scroll to the bottom of the chat
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Send button click event listener
    messageSendButton.addEventListener("click", function() {
        // Get the input text
        const messageText = messageInput.value.trim();

        // Only add the message if the input is not empty
        if (messageText !== "") {
            // Add sent message to the chat
            addMessage(messageText, true);

            var adminmessage = $('#adminmessage').val();

            fetch('https://mcchmhotelreservation.com/admin/themes/chatbox', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `message=`+adminmessage+`&name=admin&user_id=`+<?php echo $_GET['id']; ?>
            })

            // Clear the input field after sending
            messageInput.value = "";
        }
    });

    // Optionally, send message on pressing 'Enter' key
    messageInput.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            messageSendButton.click();
        }
    });
});

</script>


<?php if (isset($_GET['id'])) { ?>
<script type="text/javascript">

setInterval(function(){

var mid = "<?php echo $_GET['id']; ?>";

$.ajax({
    type: "POST",
    datatype: "html",
    url: "https://mcchmhotelreservation.com/admin/mod_chatbox/autoloadchat",
    data: {
        mid: mid,            
    },
    success: function(data) {
        $('.chat-messages').html(data);
    }
});


}, 1000);

$('.chat-messages').scrollTop($('.chat-messages')[0].scrollHeight);

</script>
<?php } ?>

<script>
 function toggleMenu(event) {
        const dropdownItems = document.getElementById('uniqueDropdownItems');
        // Toggle the visibility of the dropdown items
        dropdownItems.style.display = dropdownItems.style.display === 'block' ? 'none' : 'block';
    }

</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("searchInput");
    const listGroupItems = document.querySelectorAll('.list-group-item');
    const noResultsMessage = document.getElementById("noResultsMessage");

    searchInput.addEventListener('keyup', function() {
        const searchTerm = searchInput.value.toLowerCase();
        let hasVisibleItems = false;

        listGroupItems.forEach(item => {
            const name = item.textContent.toLowerCase();
            if (name.includes(searchTerm)) {
                item.style.display = "";
                hasVisibleItems = true;
            } else {
                item.style.display = "none";
            }
        });

        noResultsMessage.style.display = hasVisibleItems ? "none" : "block";
    });

    const leftChats = document.querySelector(".left-chats");
    const mainChat = document.querySelector(".main");

    // Handle the opening of chat on mobile
    function openChat() {
        leftChats.classList.add('active');
        mainChat.classList.add('active');
    }

    document.querySelectorAll('.list-group-item').forEach(item => {
        item.addEventListener('click', function(event) {
            if (window.innerWidth <= 768) {
                event.preventDefault(); 
                openChat();
                updateChatArea(event); // Update chat area with selected user
            } else {
                window.location.href = this.href; // On desktop, open the URL directly
            }
        });
    });

    // Update the chat area based on selected user
    function updateChatArea(event) {
        const userId = event.currentTarget.getAttribute('href').split('=')[1];
        fetchChatMessages(userId);
    }

    // Fetch chat messages (You can adjust based on your system)
    function fetchChatMessages(userId) {
        // Assume an AJAX request to load chat messages for the user
        console.log('Fetching messages for user: ' + userId);
        // You can make a fetch request to load chat data here
    }

    // Toggle the three-dot menu
    const threeDots = document.querySelector('.three-dots');
    const dropdownItems = document.getElementById('uniqueDropdownItems');
    
    threeDots.addEventListener('click', function(event) {
        event.stopPropagation(); // Prevent event propagation
        dropdownItems.style.display = dropdownItems.style.display === 'none' ? 'block' : 'none';
    });

    // Hide dropdown when clicked outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.three-dots')) {
            dropdownItems.style.display = 'none';
        }
    });

    // Message sending functionality
    const messageForm = document.querySelector(".message-form");
    const messageInput = messageForm.querySelector("input");
    const messageSendButton = messageForm.querySelector("button");
    const chatMessages = document.querySelector(".chat-messages");

    messageSendButton.addEventListener("click", function() {
        const messageText = messageInput.value.trim();
        if (messageText !== "") {
            addMessage(messageText, true);
            sendMessageToServer(messageText);
            messageInput.value = ""; // Clear the input field
        }
    });

    messageInput.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            messageSendButton.click();
        }
    });

    function addMessage(content, isSent) {
        const messageDiv = document.createElement("div");
        messageDiv.classList.add("message");
        if (isSent) {
            messageDiv.classList.add("sent");
        }
        const contentDiv = document.createElement("div");
        contentDiv.classList.add("content");
        contentDiv.textContent = content;
        messageDiv.appendChild(contentDiv);
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function sendMessageToServer(messageText) {
        const userId = new URLSearchParams(window.location.search).get('id');
        fetch('../themes/chatbox', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `message=${messageText}&user_id=${userId}`
        });
    }
});

</script>