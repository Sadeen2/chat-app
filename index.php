<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #28323f; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #28323f; 
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 80%;
            max-width: 1000px;
            background-color: #567daa;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .welcome-section {
            width: 45%;
            text-align: center;
        }

        .welcome-section h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #fbfbfb;
        }

        .welcome-section p {
            font-size: 1.2rem;
            line-height: 1.6;
            color: #fbfbfb;
        }

        .login-form {
            width: 45%;
            background-color: #e9e9e9;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;

        }

        .login-form h2 {
            margin-bottom: 1.5rem;
            color: #28323f; 
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            margin: 0.5rem 0;
            border: 1px solid #e9e9e9; 
            border-radius: 5px;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s ease;
            background-color: #fff; 
            color: #28323f; 
        }

        .login-form input[type="text"]:focus,
        .login-form input[type="password"]:focus {
            border-color: #567daa; 
        }

        .login-form input[type="checkbox"] {
            margin-right: 0.5rem;
        }

        .login-form button {
            width: 100%;
            padding: 0.75rem;
            background-color: #567daa; 
            color: #fbfbfb; 
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-form button:hover {
            background-color: #28323f; 
        }

        .login-form .remember-me {
            display: flex;
            align-items: center;
            margin: 1rem 0;
            font-size: 0.9rem;
            color: #28323f;
        }

        .login-form .error-message {
            color: #ff4444;
            margin-top: 1rem;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="welcome-section">
            <h1>Welcome!</h1>
            <p>
                Here you can send whatever messages you want to your friends.<br>
                Please, you can come in and get started.
            </p>
        </div>

        <div class="login-form">
            <h2>Login</h2>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="text" name="userid" placeholder="Enter your ID" value="<?php echo $_COOKIE['userid']; ?>">
                <input type="password" name="passcode" placeholder="Enter your password" value="<?php echo $_COOKIE['passcode']; ?>">
                <div class="remember-me">
                    <input type="checkbox" name="remember" checked> Remember Me
                </div>
                <button type="submit" name="login">Login</button>
            </form>

<p>Don't have an account? <a href="signup.php">Sign Up</a></p>
            <?php
            if (isset($_POST['login'])) {
                $userid = $_POST['userid'];
                $passcode = $_POST['passcode'];

                error_reporting(0);
                $conn = mysqli_connect("localhost", "root", "12345678", "ms2");

                $q = "SELECT * FROM users WHERE userid='$userid';";
                $c = mysqli_query($conn, $q);

                while ($d = mysqli_fetch_assoc($c)) {
                    $useridfromms = $d['userid'];
                    $passcodefromms = $d['passcode'];
                }

                if ($userid == $useridfromms && $passcode == $passcodefromms) {
                    session_start();
                    $_SESSION['userid'] = $userid;

                    if (!empty($_POST['remember'])) {
                        setcookie("userid", $userid, time() + 254654658);
                        setcookie("passcode", $passcode, time() + 254654658);
                    } else {
                        setcookie("userid", "");
                        setcookie("passcode", "");
                    }
                    header("location: profile.php");
                } else if ($userid != $useridfromms) {
                    echo '<div class="error-message">User ID does not exist!</div>';
                } else {
                    echo '<div class="error-message">Wrong password!</div>';
                }
            }
            ?>
        </div>
       
    </div>
    
</body>

</html>