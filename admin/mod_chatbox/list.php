
<style>
    .chat-messages {
    flex: 1;
    padding: 20px;
    background-color: #f8f9fa;
    overflow-y: auto;
}

.message {
    display: flex;
    margin-bottom: 15px;
}

.message.sent {
    justify-content: flex-end;
}

.message .content {
    display: inline-block; /* Ensure it only takes up as much space as the text */
    max-width: 60%; /* Set a max width so long messages wrap */
    padding: 10px;
    border-radius: 10px;
    background-color: #007bff;
    color: white;
    word-wrap: break-word; /* Ensure long words are wrapped */
}

.message.sent .content {
    background-color: #495057;
}

.message-form {
    padding: 10px;
    background-color: #e9ecef;
    display: flex;
    align-items: center;
}

.message-form input {
    flex: 1;
    padding: 10px;
    border: none;
    border-radius: 5px;
}

.message-form button {
    margin-left: 10px;
}
.chat-list-header{
    align-items: center;
    background-color: #fff;
    border-bottom: 1px solid #e0e3e4;
    color: #324148;
    display: flex;
    height: 72px;
    justify-content: space-between;
    padding: 0 15px
}
 .chat-cont-left {
    border-right: 1px solid #e0e3e4;
    flex: 0 0 35%;
    left: 0;
    max-width: 35%;
    position: relative;
    z-index: 4;
    float: left;
    
}
 .chat-cont-right {
    flex: 0 0 65%;
    max-width: 65%;
    float: left
}

.chat-cont-right .chat-header {
    align-items: center;
    background-color: #fff;
    border-bottom: 1px solid #e0e3e4;
    color: #324148;
    display: flex;
    height: 72px;
    justify-content: space-between;
    padding: 0 15px
}

</style>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="row">
            <!-- Column 1: Chat List -->
            <div class="col-md-4 chat-cont-left" style="border: 1px solid #ddd;">
                <div class="chat-list-header" style="font-size: 18px; font-weight: bold; border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
                    Chats
                </div>
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active">John Doe</a>
                    <a href="#" class="list-group-item list-group-item-action">Jane Smith</a>
                    <a href="#" class="list-group-item list-group-item-action">David Johnson</a>
                    <a href="#" class="list-group-item list-group-item-action">Emily Davis</a>
                </div>
            </div>

            <!-- Column 2: Chat Area -->
            <div class="col-md-8 chat-cont-right">
                <div class="chat-area" style="border: 1px solid #ddd;">
                    <div class="chat-header" style="font-size: 16px; font-weight: bold; border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
                        John Doe
                    </div>

                    <div class="chat-messages" style="height: 300px; overflow-y: auto; border-bottom: 1px solid #ddd; padding-bottom: 15px; margin-bottom: 15px;">
                        <!-- Messages will be dynamically added here -->
                    </div>

                    <div class="message-form" style="padding: 10px; background-color: #e9ecef; display: flex; align-items: center;">
                        <input type="text" class="form-control" placeholder="Type a message...">
                        <button class="btn btn-primary" style="margin-left: 10px;"><i class="fa fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


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


