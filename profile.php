<?php 
session_start();
$myid = $_SESSION['userid'];
error_reporting(0);
$conn = mysqli_connect("localhost", "root", "12345678", "ms2");
?>

<input type="text" name="receiver" style="display:none">

<?php

$q = "SELECT username FROM users WHERE userid='$myid';";
$c = mysqli_query($conn, $q);
while ($d = mysqli_fetch_assoc($c)) {
    $myname = $d['username'];
}


$q2 = "SELECT users.userid, users.username,
              (SELECT COUNT(*) FROM messages
               WHERE messages.sender = users.userid
               AND messages.receiver = '$myid'
               AND messages.notification = 1) AS unread_count
       FROM users
       WHERE users.userid != '$myid';";
$c2 = mysqli_query($conn, $q2);
$x = array();
while ($d2 = mysqli_fetch_assoc($c2)) {
    $x[] = $d2;
}


$rec = isset($_GET['rec']) ? $_GET['rec'] : null;

if ($rec) {
    $updateNotif = "UPDATE messages SET notification = 0
                    WHERE sender = '$rec' AND receiver = '$myid'";
    mysqli_query($conn, $updateNotif);
    
   // header("location:profile.php?rec=$rec");
}



if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message']) && $rec) {
    $message = $_POST['message'];
    if (!empty($message)) {
        date_default_timezone_set('Asia/Hebron');
        
        $currentDate = date('Y-m-d');
        $currentTime = date('h:i A');
        
        $yesterdayDate = date('Y-m-d', strtotime("-1 day"));
        $messageDate = date('Y-m-d'); 
        
        if ($messageDate == $currentDate) {
            $currentDay = "Today";
        } elseif ($messageDate == $yesterdayDate) {
            $currentDay = "Yesterday";
        } else {
            $currentDay = date('F j, Y', strtotime($messageDate));
        }
        
        $q4 = "INSERT INTO messages (sender, receiver, mss, notification, mday, mtime, mdate)
               VALUES ('$myid', '$rec', '$message', 1, '$currentDay', '$currentTime', '$currentDate')";
        mysqli_query($conn, $q4);
    }
}
?>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            overflow: hidden;
            
        }
        h1 {
            color: #007bff;
            text-align: center;
            padding: 20px;
            background-color: #b7c2e8;
            border-bottom: 1px solid #ddd;
            margin: 0;
        }
        .container {
            display: flex;
            height: 100vh;
        }
        .sidebar {
            width: 15%;
            background-color: #394570;
            color: white;
            padding: 12px;
            overflow-y: auto;
           
        }
        .sidebar a {
            display: block;
            padding: 12px;
            margin: 5px 0;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            font-size: 1rem;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background-color: #0056b3;
        }
        .main {
            width: 85%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #7284c4;
        }
        .welcome-section {
            text-align: center;
            padding: 30px;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .welcome-section img {
            width: 200px;
            margin-bottom: 20px;
        }
        .chat-container {
            width: 80%;
            display: flex;
            flex-direction: column;
            height: 60vh;
            overflow-y: auto;
            border-radius: 10px;
            padding: 35px;
            background-color: #f8f9fa;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            scroll-behavior: smooth;
        }
        .chat-bubble {
            padding: 10px 15px;
            border-radius: 15px;
            margin-bottom: 10px;
            display: inline-block;
            word-warp: break-word;
            max-width: 60%;
            min-width:10%;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .chat-bubble small {
            display: inline-block;
            font-size: 0.7rem;
            color: #666;
            margin-bottom: 1px;
        } 
        .sent {
            background-color: #007bff;
            color: white;
            align-self: flex-end;
            text-align: right;
        }
        .rec {
            background-color: #f1f1f1;
            color: black;
            align-self: flex-start;
        }
        .input-area {
            width: 84%;
            display: flex;
            align-items: center;
            background-color: white;
            padding: 10px;
            border-top: 1px solid #ddd;
            border-radius: 10px;
            
        }
        .message-input {
            flex: 1;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ced4da;
            border-radius: 15px;
            outline: none;
        }
        .send-button {
            padding: 10px 20px;
            margin-left: 10px;
            font-size: 1rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 15px;
            cursor: pointer;
        }
        .send-button:hover {
            background-color: #0056b3;
        }
        
        .logout {
            position: fixed;
            top: 20px;
            right: 20px;
            font-size: 30px;
            color: #007bff;
            cursor: pointer;
            text-decoration: none;
            transition: 0.3s;
        }

        .logout i:hover {
            color: #0056b3;
        }
        
        .logout-menu {
            display: none;
            position: absolute;
            top: 40px;
            right: 0;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 120px;
            text-align: center;
            z-index: 1000;
        }
        
        .logout-menu a {
            display: block;
            padding: 10px;
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }
        
        .logout-menu a:hover {
            background-color: #f8f9fa;
        }
       .notification-badge {
            background-color: red;
            color: white;
            font-size: 12px;
            font-weight: bold;
            border-radius: 50%;
            padding: 4px 8px;
            margin-left: 10px;
            
        }
        .date-separator {
            text-align: center;
            font-size: 14px;
            color: #666;
            margin: 15px 0;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 10px;
            display: inline-block;
        }
                
    </style>
</head>
<body>
    <h1>Welcome, <?php echo $myname; ?>!</h1>
    
    <?php
       echo "
<div class='logout'>
    <i class='fa fa-bars' aria-hidden='true' onclick='toggleLogoutMenu()'></i>
    <div id='logoutMenu' class='logout-menu'>
        <a href='logout.php'>Log Out</a>
    </div>
</div>";
       
       
       
       

    ?>
    
    
    <div class="container">
       
        <div class="sidebar"><br>
     <a href="profile.php?rec=<?php echo $rec;?>" class='notification-badge' id='note2'></a>
            <?php 
            foreach ($x as $user) {
                $username = $user['username'];
                $userid = $user['userid'];
                $unread_count = $user['unread_count'];  
        
               $notificationBadge = $unread_count > 0 ? "<span class='notification-badge'>$unread_count</span>" : "";
        
                if (!empty($username)) { 
                    $_SESSION['receiver']=$rec;
                    //$notificationBadge = $unread_count > 0 ? "<span class='notification-badge' id='note'></span>" : "";
                    
                    echo "
            <a href='profile.php?rec=$userid'>
                $username $notificationBadge
            </a>";
                }
            }
            ?>
        </div>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>       
        
        <script>
       
$(document).ready
(function() {
   
    function updatenotifications() {
        $.ajax({
            url: 'notifications.php', 
            method: 'GET', 
           
               success: function(data) {
            if(data!=0){
            document.getElementById('note2').innerHTML=data;
            
           
             }
                
                
            },
            error: function() {
                console.error('error loading notifications');
            }
        });
    }
    
    
    setInterval(updatenotifications, 1000); 
}); 
        
        
        
        
        
        
        
        
        </script>
          
        <div class="main">
            <?php if (!$rec): ?>
                <div class="welcome-section">
                    <img src="https://cdn-icons-png.flaticon.com/512/3098/3098121.png" alt="Chat Illustration">
                    <h2>Welcome to Your Messages</h2>
                    <p>Select a user from the left sidebar to start chatting.</p>
                </div>
            <?php else: ?>
                <div class="chat-container">
                    <?php 
                        $q3 = "SELECT * FROM messages WHERE (sender='$myid' AND receiver='$rec') OR (sender='$rec' AND receiver='$myid') ORDER BY mdate ASC, mtime ASC;";
                        $c3 = mysqli_query($conn, $q3);
                        
                        $lastDate = "";  
                        while ($msg = mysqli_fetch_assoc($c3)) {
                            $sender = $msg['sender'];
                            $message = $msg['mss'];
                            $formattedTime = $msg['mtime'];
                            $formattedDate = $msg['mdate']; 
                        
                            $today = date('Y-m-d');
                            $yesterday = date('Y-m-d', strtotime('-1 day'));
                            
                            if ($formattedDate == $today) {
                                $displayDate = "Today";
                            } elseif ($formattedDate == $yesterday) {
                                $displayDate = "Yesterday";
                            } else {
                                $displayDate = date('F j, Y', strtotime($formattedDate)); 
                            }
                        
                            if ($formattedDate != $lastDate) {
                                echo "<div class='date-separator'>$displayDate</div>";
                                $lastDate = $formattedDate;
                            }
                        
                            $senderQuery = "SELECT username FROM users WHERE userid = '$sender'";
                            $senderResult = mysqli_query($conn, $senderQuery);
                            $senderData = mysqli_fetch_assoc($senderResult);
                            $senderName = $senderData['username'];
                            
                            if ($sender == $myid) {
                                echo "<div class='chat-bubble sent'>";
                                echo "$message";
                                echo "&nbsp;<small><strong>You</strong> • $formattedTime</small>";
                                echo "</div>";
                            } else {
                                echo "<div class='chat-bubble rec'>";
                                echo "$message";
                                echo "&nbsp;<small><strong>$senderName</strong> • $formattedTime</small>";
                                echo "</div>";
                            }
                        }
                    ?>
                                            
                </div>
                <form method="post" class="input-area">
                    <input type="text" name="message" class="message-input" placeholder="Type your message here...">
                    <button type="submit" class="send-button">Send</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
<script>
function toggleLogoutMenu() {
    var menu = document.getElementById("logoutMenu");
    if (menu.style.display === "block") {
        menu.style.display = "none";
    } else {
        menu.style.display = "block";
    }
}

document.addEventListener("click", function(event) {
    var menu = document.getElementById("logoutMenu");
    var icon = document.querySelector(".logout i");
    if (!menu.contains(event.target) && event.target !== icon) {
        menu.style.display = "none";
    }
});
</script>
</html>




