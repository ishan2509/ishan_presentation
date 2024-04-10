<?php
session_start(); // start the session

// database details
require_once '../dbinfo.php';

// Initialize error variable
$error = '';

// check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // query to check username and password
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        // username and password are correct, set user type in session and redirect to users.php
        $row = $result->fetch_assoc();
        $_SESSION['role'] = $row['role'];
        $_SESSION['loggedin'] = true;
        header("Location: admin-index.php");
        exit();
    } else {
        // username and password are incorrect, set error message
        $error = "Invalid username or password";
    }
}?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            width: 300px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .login-container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .input-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 8px;
            border: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <form action="" method="POST">
        <?php if (!empty($error)) { ?><div style="color: red;"><?php echo $error; ?></div><?php } ?><br>
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
            <div class="footer">
                <p>Return to&#160;<a href="../index.php">Home Page</a></p>
            </div>
            
        </form>
    </div>
</body>
</html>
