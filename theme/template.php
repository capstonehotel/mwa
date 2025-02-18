<?php
if(isset($_POST['avail'])){
$_SESSION['from'] = $_POST['from'];
$_SESSION['to']  = $_POST['to'];
  redirect( "https://mcchmhotelreservation.com/index.php?page=5");
}
?>

<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head><script src="https://mcchmhotelreservation.com/theme/assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.115.4">
    <link rel="stylesheet" type="text/css" href="https://mcchmhotelreservation.com/fonts/css/font-awesome.min.css" />
    <title><?php echo isset($title) ? $title . ' | HM Hotel' : 'HM mini Hotel' ; ?></title>
   
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/navbars-offcanvas/">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <link href="https://mcchmhotelreservation.com/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen" />
    <link href="https://mcchmhotelreservation.com/css/datepicker.css" rel="stylesheet" media="screen" />

     <link href="cccss/galery.css" rel="stylesheet" media="screen" />
    <link href="https://mcchmhotelreservation.com/css/ekko-lightbox.css" rel="stylesheet" />

    <!--<link href="https://mcchmhotelreservation.com/theme/translate.css" rel="stylesheet">-->
    <link href="https://mcchmhotelreservation.com/theme/assets/dist/css/bootstrap.min.css" rel="stylesheet">
   

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
    
    
    
    //Secure session cookie settings
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
  //   setcookie("cookie_name", "cookie_value", [
  //     'expires' => time() + 3600, // 1 hour
  //     'path' => '/',
  //     'domain' => 'mcchmhotelreservation.com',
  //     'secure' => true, // Only send cookie over HTTPS
  //     'httponly' => true, // Prevent JavaScript access
  //     'samesite' => 'Lax' // Prevent CSRF
  // ]);

    
        if (isset($_SESSION['monbela_cart'])){
            if (count($_SESSION['monbela_cart'])>0) { $cart = '
                <span class="carttxtactive"> '.count($_SESSION['monbela_cart']) .' </span>
                '; } } if (isset($_SESSION['activity'])){ if (is_array($_SESSION['activity']) && count($_SESSION['activity'])>0) { $activity = '
                <span class="carttxtactive"> '.count($_SESSION['activity']) .' </span>
                ';
            }
        }

    ?>

<!-- 
 <script type="text/javascript">
    // Disable right-click with an alert
    document.addEventListener('contextmenu', function(event) {
        event.preventDefault();
       // alert("Right-click is disabled on this page.");
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
           // alert("Inspect Element is disabled.");
            e.preventDefault();
            return false;
        }

        // Ctrl + Shift + J (Console)
        if (e.ctrlKey && e.shiftKey && e.key === "J") {
           // alert("Console is disabled.");
            e.preventDefault();
            return false;
        }


         // Ctrl + U or Ctrl + u (View Source)
         if (e.ctrlKey && (e.key === "U" || e.key === "u" || e.keyCode === 85)) {
           // alert("Viewing page source is disabled.");
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

</script>  -->
<?php
// $disallowedUserAgents = [
//     "BurpSuite", 
//     "Cyberfox", 
//     "OWASP ZAP", 
//     "PostmanRuntime"
// ];

// if (preg_match("/(" . implode("|", $disallowedUserAgents) . ")/i", $_SERVER['HTTP_USER_AGENT'])) {
//     http_response_code(403);
//     exit("Unauthorized access");
// }
?>
 
<style>
  .bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
  }

  @media (min-width: 768px) {
    .bd-placeholder-img-lg {
      font-size: 3.5rem;
    }
  }

  .b-example-divider {
    width: 100%;
    height: 3rem;
    background-color: rgba(0, 0, 0, .1);
    border: solid rgba(0, 0, 0, .15);
    border-width: 1px 0;
    box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
  }

  .b-example-vr {
    flex-shrink: 0;
    width: 1.5rem;
    height: 100vh;
  }

  .bi {
    vertical-align: -.125em;
    fill: currentColor;
  }

  .nav-scroller {
    position: relative;
    z-index: 2;
    height: 2.75rem;
    overflow-y: hidden;
  }

  .nav-scroller .nav {
    display: flex;
    flex-wrap: nowrap;
    padding-bottom: 1rem;
    margin-top: -1px;
    overflow-x: auto;
    text-align: center;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
  }

  .btn-bd-primary {
    --bd-violet-bg: #712cf9;
    --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

    --bs-btn-font-weight: 600;
    --bs-btn-color: var(--bs-white);
    --bs-btn-bg: var(--bd-violet-bg);
    --bs-btn-border-color: var(--bd-violet-bg);
    --bs-btn-hover-color: var(--bs-white);
    --bs-btn-hover-bg: #6528e0;
    --bs-btn-hover-border-color: #6528e0;
    --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
    --bs-btn-active-color: var(--bs-btn-hover-color);
    --bs-btn-active-bg: #5a23c8;
    --bs-btn-active-border-color: #5a23c8;
  }
  .bd-mode-toggle {
    z-index: 1500;
  }
  /* Chatbox button */
  #chat-button {
    position: fixed;
    bottom: 70px;
    right: 20px;
    z-index: 2100; /* Ensure it's above the chatbox */
    width: 48px; /* Adjust width to match toggle theme button */
    height: 48px; /* Adjust height to match toggle theme button */
    font-size: 24px; /* Adjust icon size */
    line-height: 1; /* Ensure proper vertical alignment */
}

.chatbox {
    position: fixed;
    bottom: 90px; 
    right: 70px; /* Adjusted for better positioning */
    width: 350px; /* Increased width */
    background-color: #f9f9f9; /* Soft background color */
    border: 1px solid #ddd; /* Light border */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    height: 0; /* Start with height 0 */
    opacity: 0; /* Start with opacity 0 */
    overflow: hidden; /* Hide overflow */
    transform: scale(0) translate(0, 100%); /* Start with scale 0 and translate down */
    transform-origin: bottom right; /* Set the origin for scaling to the bottom right */
    transition: height 0.3s ease, opacity 0.3s ease, transform 0.3s ease; /* Transition for height, opacity, and transform */
    z-index: 2200;
}

.chatbox-header {
    background-color: #007bff; /* Header color */
    color: #fff; /* Text color */
    padding: 15px; /* Increased padding */
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top-left-radius: 10px; /* Match border radius */
    border-top-right-radius: 10px; /* Match border radius */
}

.chatbox-title {
    font-weight: bold;
    font-size: 20px; /* Increased font size */
}

.close-button {
    background: none;
    border: none;
    color: #fff;
    cursor: pointer;
    font-size: 24px; /* Increased close button size */
}

.chat-messages {
    height: 250px; /* Fixed height */
    overflow-y: auto; /* Scrollable */
    padding: 10px;
    display: flex;
    flex-direction: column-reverse; /* Reverse order for newer messages at the bottom */
}

.message {
    padding: 10px; /* Increased padding */
    margin: 5px 0;
    border-radius: 8px; /* Rounded corners for messages */
    max-width: 80%;
    font-size: 14px; /* Font size */
}

/* User message (sent) */
.message.received {
    background-color: #007bff; /* User message background */
    color: white; /* User message text color */
    align-self: flex-end; /* Align to the right */
}

/* Admin message (received) */
.message.sent {
    background-color: #e0e0e0; /* Admin message background */
    color: #333; /* Admin message text color */
    align-self: flex-start; /* Align to the left */
}

.chat-input {
    display: flex;
    align-items: center;
    padding: 10px;
    border-top: 1px solid #ddd; /* Light border on top */
}

#message-input {
    flex: 1;
    padding: 10px; /* Increased padding */
    border: 1px solid #ccc; /* Light border */
    border-radius: 4px; /* Rounded corners */
    margin-right: 10px;
}

#send-button {
    padding: 10px 20px; /* Increased padding */
    background-color: #007bff; /* Button color */
    color: #fff; /* Button text color */
    border: none;
    border-radius: 4px; /* Rounded corners */
    cursor: pointer;
}

#send-button:hover {
    background-color: #0056b3; /* Darker on hover */
}



#google_translate_element {
  position: absolute;
  z-index: 1000;
}

/* Translate button */
#translate-button {
  position: fixed;
  bottom: 130px;
  right: 20px;
  z-index: 2300; /* Ensure it's above the translate container */
  width: 48px; /* Adjust width to match toggle theme button */
  height: 48px; /* Adjust height to match toggle theme button */
  font-size: 24px; /* Adjust icon size */
  line-height: 1; /* Ensure proper vertical alignment */
}

/* Translate container */
#translate-container {
  position: fixed;
  bottom: 120px; /* Adjusted to prevent overlap with button */
  right: 80px;
  width: 300px;
  background-color: #fff;
  border: 1px solid #ccc;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  display: none;
  z-index: 1000;
  max-height: calc(100vh - 100px); /* Ensure it fits within viewport */
  overflow-y: auto; /* Enable scrolling within the translate container */
}

#translate-container.open {
  display: block;
}
 /* Hide Google Translate widget */
 #google_translate_element {
      z-index: -1; /* Position the widget behind other elements */
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      opacity: 0;
    }
    iframe.goog-te-banner-frame {
      display: none !important;
    }
    .goog-logo-link {
      display: none !important;
    }
    .goog-te-gadget {
      color: transparent !important;
    }
    .skiptranslate {
      display: none !important;
    }
</style>
  

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<div id="google_translate_element"></div>
<script >
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({pageLanguage: 'en' }, 'google_translate_element');
  }
</script>
    
    <!-- Custom styles for this template -->
    <link href="styles.css" rel="stylesheet">
  </head>
  <body >
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
      <symbol id="check2" viewBox="0 0 16 16">
        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
      </symbol>
      <symbol id="circle-half" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
      </symbol>
      <symbol id="moon-stars-fill" viewBox="0 0 16 16">
        <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
        <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/>
      </symbol>
      <symbol id="sun-fill" viewBox="0 0 16 16">
        <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
      </symbol>
    </svg>
  
<main>
  <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
      <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center"
              id="bd-theme"
              type="button"
              aria-expanded="false"
              data-bs-toggle="dropdown"
              aria-label="Toggle theme (auto)"
              style="background-color: #712cf9; border-color: #712cf9;">
        <svg class="bi my-1 theme-icon-active" width="1em" height="1em"><use href="#circle-half"></use></svg>
        <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
      </button>
      <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
        <li>
          <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false" >
            <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em" ><use href="#sun-fill"></use></svg>
            Light
            <svg class="bi ms-auto d-none" width="1em" height="1em" ><use href="#check2"></use></svg>
          </button>
        </li>
        <li>
          <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
            <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#moon-stars-fill"></use></svg>
            Dark
            <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
          </button>
        </li>
        <li>
          <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
            <svg  id="icon-circle-half" class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#circle-half"></use></svg>
            Auto
            <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
          </button>
        </li>
      </ul>
    </div>
<!-- Translate button -->
<button id="translate-button" class="btn btn-primary">
    <i class="fa fa-language"></i>
  </button>

   <!-- Translate container -->
   <div id="translate-container">
    <select id="select-language" class="form-control">
      <option value="">Select Language</option>
      <option value="en">English</option>
      <option value="ceb">Cebuano</option>
      <option value="tl">Tagalog</option>
    </select>
  </div>

  <div id="google_translate_element" style="display: none;"></div>
  <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
  <script>
    function googleTranslateElementInit() {
      new google.translate.TranslateElement({
        pageLanguage: 'en',
        includedLanguages: 'en,ceb,tl',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
      }, 'google_translate_element');
    }
    document.getElementById('translate-button').addEventListener('click', function() {
      document.getElementById('translate-container').classList.toggle('open');
    });

    document.getElementById('select-language').addEventListener('change', function() {
      var languageCode = this.value;
      if (languageCode) {
        translateContent(languageCode);
        document.getElementById('translate-container').classList.remove('open');
      }
    });
    function translateContent(languageCode) {
      var googleTranslateCombo = document.querySelector('#google_translate_element select');
      if (googleTranslateCombo) {
        googleTranslateCombo.value = languageCode;
        // Trigger change event on the select element
        googleTranslateCombo.dispatchEvent(new Event('change'));
      }
    }
  </script>


<?php
// Check if the user is logged in
$isLoggedIn = isset($_SESSION['GUESTID']);
?>

<!-- Chatbox button -->
<button id="chat-button" class="btn btn-primary"<?php echo $isLoggedIn ? '' : 'disabled'; ?>>
    <i class="fa fa-comments"></i> <!-- Replace 'fa-comments' with the specific icon you want -->
</button>

<!-- Chatbox container -->
<?php

?>

<div id="chatbox" class="chatbox">
    <div class="chatbox-header">
        <span class="chatbox-title">Chat with Admin</span>
        <button class="close-button" onclick="closeChatbox()">×</button>
    </div>
    <div id="chat-messages" class="chat-messages">
        <!-- Initial admin greeting message -->
        <!-- <div class="message received">
            Hello, how can I help you?
        </div> -->
        

    </div>
    <div class="chat-input">
        <textarea id="message-input" placeholder="Type your message..." oninput="checkInput()"></textarea>
        <button id="send-button" onclick="sendMessage()" disabled><i class="fa fa-paper-plane" aria-hidden="true"></i> </button>
    </div>
</div>
<script>
  function sanitizeMessage(message) {
    const element = document.createElement('div');
    element.innerText = message; // Escapes HTML entities
    return element.innerHTML;
}
    function checkInput() {
        const messageInput = document.getElementById('message-input');
        const sendButton = document.getElementById('send-button');
        sendButton.disabled = messageInput.value.trim() === '';
    }

    function sendMessage() {
    const messageInput = document.getElementById('message-input');
    const message = messageInput.value.trim();
    const name = '<?php echo $_SESSION['name'] . " " . $_SESSION['last']; ?>';
    const userId = <?php echo json_encode($_SESSION['GUESTID']); ?>;

    if (message) {
        const sanitizedMessage = sanitizeMessage(message); // Sanitize the input message
        let userMessageElement = document.createElement('div');
        userMessageElement.innerHTML = sanitizedMessage; // Use innerHTML after sanitizing

        userMessageElement.classList.add('message', 'received');
        if (sanitizedMessage.length < 20) {
            userMessageElement.style.backgroundColor = '#007bff';
        } else {
            userMessageElement.style.backgroundColor = '#5bc0de';
        }

        document.getElementById('chat-messages').appendChild(userMessageElement);
        messageInput.value = '';
        checkInput();

        fetch('https://mcchmhotelreservation.com/admin/themes/chatbox', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `message=${encodeURIComponent(sanitizedMessage)}&name=${encodeURIComponent(name)}&user_id=${userId}`
        })
        .then(response => response.text())
        .then(data => {
            console.log('Response from server:', data);
            if (data === 'Sent') {
                console.log('Message sent successfully');
            } else {
                console.log('Server error:', data);
            }
        })
        .catch(error => console.error('Error:', error));
    } else {
        alert('Please enter a message');
    }
}
    const isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
    document.getElementById('chat-button').addEventListener('click', function() {
      if (!isLoggedIn) {
            alert('Please log in to use the chat feature.');
            return;
        }
        const chatbox = document.getElementById('chatbox');
        if (chatbox.classList.contains('open')) {
            closeChatbox();
        } else {
            chatbox.classList.add('open');
            chatbox.style.height = chatbox.scrollHeight + "px";
            chatbox.style.opacity = "1";
            chatbox.style.transform = "scale(1) translate(0, 0)";
        }
    });

    function closeChatbox() {
        const chatbox = document.getElementById('chatbox');
        chatbox.style.height = "0";
        chatbox.style.opacity = "0";
        chatbox.style.transform = "scale(0) translate(0, 100%)";
        setTimeout(() => {
            chatbox.classList.remove('open');
        }, 300);
    }

    setInterval(function() {
        const mid = "<?php echo $_SESSION['GUESTID']; ?>";

        fetch("https://mcchmhotelreservation.com/admin/mod_chatbox/autoloadchat", {
            method: "POST",
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `mid=${mid}`
        })
        .then(response => response.text())
        .then(data => {
            document.querySelector('.chat-messages').innerHTML = data;
        });
    }, 1000);
</script>


  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large" style="background: linear-gradient(to bottom, #a0201c, #790505 70%);">
    <div class="container-fluid">
      <a class="navbar-brand"><img src="https://mcchmhotelreservation.com/images/logo2.jpg" style="width: 40px; height: 40px; border-radius: 30px; margin-left: 2px;">  HM Hotel Reservation</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbar2Label">HM Hotel Reservation</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <?php
           $accomodation = New Accomodation();
           $cur = $accomodation->listOfaccomodation(); ?>
          <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link <?php if(!isset($_GET['p'])){echo "active";} ?>" href="https://mcchmhotelreservation.com/index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if(isset($_GET['p']) && $_GET['p'] == "rooms"){echo "active";} ?>" href="https://mcchmhotelreservation.com/index.php?p=rooms">Room and Rates</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle <?php if(isset($_GET['p']) && $_GET['p'] == "accomodation"){echo "active";} ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Accomodation
              </a>
              <ul class="dropdown-menu">
                <?php  foreach ($cur as $result) { ?>
                    <li>
                        <a class="dropdown-item <?php if(isset($_GET['q']) && $_GET['q'] == $result->ACCOMODATION){echo "active";} ?>" href="https://mcchmhotelreservation.com/index.php?p=accomodation&q=<?php echo $result->ACCOMODATION; ?>"><?php echo $result->ACCOMODATION; ?></a>
                    </li>
                <?php } ?>
              </ul>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link <?php if(isset($_GET['p']) && $_GET['p'] == "contact"){echo "active";} ?>" href="https://mcchmhotelreservation.com/index.php?p=contact">Contact Us</a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link <?php if(isset($_GET['p']) && $_GET['p'] == "about-us"){echo "active";} ?>" href="https://mcchmhotelreservation.com/index.php?p=about-us">About us</a>
            </li>
          </ul>
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item" >
              <a class="nav-link active" data-toggle="tooltip" title="Booking Cart"  href="<?php echo 'https://mcchmhotelreservation.com/booking/index.php';  ?>"><i class="fa fa-shopping-cart" style="display: flex; font-size: 25px;"><?php echo  isset($cart) ? $cart : '' ; ?>  </i> 
             </a>

            </li>

            
           <?php if (isset($_SESSION['GUESTID'])) {

    $sql = "SELECT count(*) as MSG FROM `tblpayment` WHERE STATUS<>'Pending'  AND  `MSGVIEW`=0 AND `GUESTID`=" . $_SESSION['GUESTID'];
    $mydb->setQuery($sql);
    $res = $mydb->executeQuery(); 

    $msgCnt = $mydb->fetch_array($res);
?>
<li class="nav-item dropdown">
    <a class="nav-link active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-envelope-o" style="font-size: 20px;"></i>
        <span class="label label-success"><?php echo $msgCnt['MSG']; ?></span>
        <i class="fa fa-caret-down fa-fw"></i> 
    </a>
    <ul class="dropdown-menu scrollable-dropdown">
        <li class="header">You have <?php echo $msgCnt['MSG']; ?> messages</li>
        <?php 
        $sql = "SELECT  *  FROM `tblpayment` WHERE STATUS<>'Pending' AND `MSGVIEW`=0 AND `GUESTID`=" . $_SESSION['GUESTID'];
        $result = $connection->query($sql);
        while ($row = $result->fetch_assoc()) {
        ?>
        <li>
            <a target="_blank" class="read dropdown-item" href="https://mcchmhotelreservation.com/guest/readmessage.php?code=<?php echo $row['CONFIRMATIONCODE']; ?>" data-toggle="lightbox" data-id="<?php echo $row['CONFIRMATIONCODE']; ?> ">
                <div class="pull-left">
                    <img src="https://mcchmhotelreservation.com/images/1607134500_avatar.jpg" style="width: 30px; height: 30px; border-radius: 50%;" alt="">
                </div>
                <h4>Admin</h4>
                <p>Reservation is already <?php echo $row['STATUS']; ?>..</p> 
            </a>
        </li>
        <?php } ?>
    </ul>
</li>

<style>
  .scrollable-dropdown {
    max-height: 300px; /* Adjust height based on your preference */
    overflow-y: auto;
    overflow-x: hidden;
}

</style>

          <?php 
//   
            $g = New Guest() ;
            $result = $g->single_guest($_SESSION['GUESTID']);

            ?>

          
                    <li class="nav-item dropdown" >
                      <a class="nav-link active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                         <i class="fa fa-user fa-fw"></i><?php echo $_SESSION['name']. ' ' . $_SESSION['last']; ?> <i class="fa fa-caret-down fa-fw"></i> 
                      </a>
                      <ul class="dropdown-menu" style="width: 200px;">
                          
                    <li class="widget-user-header bg-yellow">
                      <div class="widget-user-image" style="padding-top: 20px; text-align: center;">
                        <img class="img-circle" style="cursor:pointer;width:80px;height:80px;padding:0; border-radius: 50%; text-align: center;"  data-target="#myModal" data-toggle="modal" src="<?php echo 'https://mcchmhotelreservation.com/images/user_avatar/'.$result->G_AVATAR;  ?>" alt="User Avatar">
                      </div>
                      <h5 style="text-align: center;" class="widget-user-username"><?php echo $_SESSION['name']. ' ' . $_SESSION['last']; ?> </h5>
                    </li>

                    <li>
                        <a class="dropdown-item" style="color:#000;text-align:left;border-bottom:1px solid #fff;"
                    href="https://mcchmhotelreservation.com/guest/profile.php" data-toggle="lightbox" >Account</a>
                    </li>
                    <li><a class="dropdown-item" style="color:#000;text-align:left;border-bottom:1px solid #fff;" 
                href="https://mcchmhotelreservation.com/guest/bookinglist.php" data-toggle="lightbox">Bookings</a>
                    </li>
                    <li>
                        <a class="dropdown-item" style="color:#000;text-align:left;border-bottom:1px solid #fff;" href="<?php echo 'https://mcchmhotelreservation.com/logout.php';  ?>">Logout </a>
                    </li>
                       
                </ul>
            </li>
 
          </li>

          <?php } ?>
           <!--<a class="text-light my-auto text-decoration-none ms-lg-2" href="https://mcchmhotelreservation.com/admin/login.php" style="color: whitesmoke;">
             <span class="d-lg-inline d-none">|</span> <span class="ms-lg-2"><i class="fa fa-sign-in"></i> Login-Admin</span></a> -->
          </ul>
          <?php  
 // }
?>
        </div>
      </div>
    </div>
  </nav>

   <div class="modal fade" id="myModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">×</button>

                        <h4 class="modal-title" id="myModalLabel">Choose Image.</h4>
                    </div>

                    <form action="https://mcchmhotelreservation.com/guest/update.php" enctype="multipart/form-data" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="rows">
                                    <div class="col-md-12">
                                        <div class="rows">
                                            <div class="col-md-8"><input name="MAX_FILE_SIZE" type="hidden" value="1000000" /> <input id="image" name="image" type="file" /></div>

                                            <div class="col-md-4"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer"><button class="btn btn-default" data-dismiss="modal" type="button">Close</button> <button class="btn btn-primary" name="savephoto" type="submit">Upload Photo</button></div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

  <div>
    <div class="bg-body-tertiary">
        <div class="col-sm-12 py-2 mx-auto" style="max-width: 1000px">
             <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img style="height: 400px"  src="https://mcchmhotelreservation.com/images/high.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                  <img style="height: 400px"   src="https://mcchmhotelreservation.com/images/high.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                  <img style="height: 400px"  src="https://mcchmhotelreservation.com/images/high.jpg" class="d-block w-100" alt="...">
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
        </div>
    </div>
    <div class="bg-body-tertiary ">
        
      <div class="col-sm-12 py-2 mx-auto" style="max-width: 1000px">
        <?php 
            require_once $content;  
        ?>
    </div>
    </div>
  </div>

</main>

<script src="https://mcchmhotelreservation.com/theme/assets/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

 <script src="https://mcchmhotelreservation.com/jquery/jquery.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="https://mcchmhotelreservation.com/js/bootstrap.min.js"></script>

        <!-- DataTables JavaScript -->
        <script src="https://mcchmhotelreservation.com/js/jquery.dataTables.min.js"></script>
        <script src="https://mcchmhotelreservation.com/js/dataTables.bootstrap.min.js"></script>

        <script type="text/javascript" src="https://mcchmhotelreservation.com/js/bootstrap-datepicker.js" charset="UTF-8"></script>
        <script type="text/javascript" src="https://mcchmhotelreservation.com/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
        <script type="text/javascript" src="https://mcchmhotelreservation.com/js/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>
        <!-- Custom Theme JavaScript -->

        <script src="https://mcchmhotelreservation.com/js/ekko-lightbox.js"></script>
        <script type="text/javascript" language="javascript" src="https://mcchmhotelreservation.com/js/plugins.js"></script>
        <script type="text/javascript" language="javascript" src="https://mcchmhotelreservation.com/js/html5.js"></script>
        <script type="text/javascript" language="javascript" src="https://mcchmhotelreservation.com/js/retina.js"></script>
        <script type="text/javascript" language="javascript" src="https://mcchmhotelreservation.com/js/global.js"></script>

        <script>
            // tooltip demo
            $(".tooltip-demo").tooltip({
                selector: "[data-toggle=tooltip]",
                container: "body",
            });

            // popover demo
            $("[data-toggle=popover]").popover();
        </script>

        <script type="text/javascript">
            $(".date_pickerfrom").datetimepicker({
                format: "mm/dd/yyyy",
                startDate: new Date(),
                language: "en",
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                minView: 2,
                forceParse: 0,
            });

            $(".date_pickerto").datetimepicker({
                format: "mm/dd/yyyy",
                startDate: "01/01/2000",
                language: "en",
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                minView: 2,
                forceParse: 0,
            });
            
            function updateDatePickerToStartDate() {
     var selectedDate = $('#date_pickerfrom').val();
     $('#date_pickerto').val(selectedDate); // Update the input field's value
     $("#date_pickerto").datetimepicker("setStartDate", selectedDate);
     $('#date_pickerto').datetimepicker('update'); // Update the datetimepicker display
   }
            

            $('#date_pickerfrom').on('change', updateDatePickerToStartDate);

   // Set the initial value of date_pickerto based on date_pickerfrom's value
   const initialDateFromValue = $('#date_pickerfrom').val();
   $('#date_pickerto').val(initialDateFromValue);
   $('#date_pickerto').datetimepicker('update');

            $(document).ready(function () {
                $(".gallery-item").hover(
                    function () {
                        $(this).find(".img-title").fadeIn(400);
                    },
                    function () {
                        $(this).find(".img-title").fadeOut(100);
                    }
                );
            });


            $(document).ready(function() {
    var maxDate = new Date();
    maxDate.setFullYear(maxDate.getFullYear() - 21);

    $(".dbirth").datetimepicker({
        format: "mm/dd/yyyy",
        endDate: maxDate,
        language: "en",
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0,
    });
});


            //Validates Personal Info
            function personalInfo() {
    var a = document.forms["personal"]["name"].value;
    var b = document.forms["personal"]["last"].value;
    var b1 = document.forms["personal"]["gender"].value; 
    var c = document.forms["personal"]["city"].value;
    var d = document.forms["personal"]["address"].value;
    var e = document.forms["personal"]["dbirth"].value;
    var f = document.forms["personal"]["zip"].value;
    var g = document.forms["personal"]["phone"].value;
    var h = document.forms["personal"]["username"].value;
    var i = document.forms["personal"]["password"].value;
    
    
    if (document.personal.condition.checked == false) {
        Swal.fire({
            icon: 'error',
            title: 'Terms & Conditions',
            text: 'Please agree to the terms and conditions of this hotel.',
        });
        return false;
    }

    if (
        a == "Firstname" ||
        a == "" ||
        b == "lastname" ||
        b == "" ||
        b1 == "gender" ||
        b1 == "" ||
        c == "City" ||
        c == "" ||
        d == "address" ||
        d == "" ||
        e == "dateofbirth" ||
        e == "" ||
        f == "Zip" ||
        f == "" ||
        g == "Phone" ||
        g == "" ||
        h == "username" ||
        h == "" ||
        i == "password" ||
        i == ""
    ) {
        Swal.fire({
            icon: 'warning',
            title: 'Missing Information',
            text: 'All fields are required!',
        });
        return false;
    }

    return true;
}

        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!--/.container-->
        <script language="javascript" type="text/javascript">
            function OpenPopupCenter(pageURL, title, w, h) {
                var left = (screen.width - w) / 2;
                var top = (screen.height - h) / 4; // for 25% - devide by 4  |  for 33% - devide by 3
                var targetWin = window.open(pageURL, title, "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=" + w + ", height=" + h + ", top=" + top + ", left=" + left);
            }
        </script>
        
      </body>
</html>
