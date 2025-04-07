
<?php
session_start();
$conn = mysqli_connect("localhost", "root", "12345678", "ms2");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username =  $_POST['username'];
    $userid = $_POST['userid'];
    $password = $_POST['password']; 

    $checkUser = "SELECT * FROM users WHERE userid='$userid'";
    $result = mysqli_query($conn, $checkUser);

    if (mysqli_num_rows($result) > 0) {
        $message = "User ID already exists!";
    } else {
        $query = "INSERT INTO users (userid, username, passcode) VALUES ('$userid', '$username', '$password')";
        if (mysqli_query($conn, $query)) {
            header("Location: index.php"); 
            exit();
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #28323f;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .signup-container {
            background-color: #567daa;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        .signup-container h2 {
            color: black;
        }
        .signup-container input {
            width: 80%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .signup-container button {
            width: 85%;
            padding: 10px;
            background-color: #e9e9e9;
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .signup-container button:hover {
            background-color: #3c5c82;
        }
        .error-message {
            color: red;
            font-size: 14px;
        }
        .login-link {
            margin-top: 10px;
            font-size: 17px;
        }
        .login-link a {
            color: #e9e9e9;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="signup-container">
    <h2>Sign Up</h2>
    <form method="POST">
        <input type="text" name="userid" placeholder="User ID" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <br><br><button type="submit">Register</button>
    </form>
    <?php if ($message != "") echo "<p class='error-message'>$message</p>"; ?>

    <p class="login-link">Already have an account? <a href="index.php">Login</a></p>
</div>

</body>
</html>