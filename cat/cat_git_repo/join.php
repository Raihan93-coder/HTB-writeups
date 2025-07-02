<?php
session_start();

include 'config.php';

$success_message = "";
$error_message = "";

// Registration process
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['registerForm'])) {
    $username = $_GET['username'];
    $email = $_GET['email'];
    $password = md5($_GET['password']);

    $stmt_check = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
    $stmt_check->execute([':username' => $username, ':email' => $email]);
    $existing_user = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if ($existing_user) {
        $error_message = "Error: Username or email already exists.";
    } else {
        $stmt_insert = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt_insert->execute([':username' => $username, ':email' => $email, ':password' => $password]);

        if ($stmt_insert) {
            $success_message = "Registration successful!";
        } else {
            $error_message = "Error: Unable to register user.";
        }
    }
}

// Login process
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['loginForm'])) {
    $username = $_GET['loginUsername'];
    $password = md5($_GET['loginPassword']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password === $user['password']) {
        $_SESSION['username'] = $user['username'];
        header("Location: /");
        exit();
    } else {
        $error_message = "Incorrect username or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Join the Best Cat Community</title>
<link rel="stylesheet" href="css/styles.css">
<style>
    .container {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .card {
        overflow: hidden;
        transition: height 0.3s ease-in-out;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 40px; /* Increased margin between cards */
    }
    .card.register {
        height: 400px;
    }
    .card.login {
        height: 400px;
    }
    form {
        padding: 20px;
        box-sizing: border-box;
    }
    label,
    input {
        display: block;
        margin-bottom: 10px;
        width: 100%; /* Make inputs fill the width */
    }
    input[type="submit"] {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 15px 20px;
        cursor: pointer;
        transition: background-color 0.3s;
        width: 100%; /* Make button fill the width */
    }
    input[type="submit"]:hover {
        background-color: #0056b3;
    }
    .toggle-link {
        text-align: center;
        margin-bottom: 20px;
    }
    .toggle-link a {
        text-decoration: none;
        color: #007bff;
        transition: color 0.3s;
    }
    .toggle-link a:hover {
        color: #0056b3;
    }
    .message {
        margin-top: 20px;
        text-align: center;
        color: green;
    }
    .error-message {
        margin-top: 20px;
        text-align: center;
        color: red;
    }
</style>
</head>
<body>

<div class="navbar">
    <a href="/">Home</a>
    <a href="/vote.php">Vote</a>
    <a href="/contest.php">Contest</a>
    <a href="/winners.php">Winners</a>
    <a href="/join.php">Join</a>
</div>

<div class="container">
    <h1>Join the Best Cat Community</h1>
    <?php if ($success_message != ""): ?>
        <div class="message"><?php echo $success_message; ?></div>
    <?php endif; ?>
    <?php if ($error_message != ""): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <div class="card register">
        <center><h2>Register</h2></center>
        <form id="registerForm" method="get">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" name="registerForm" value="Register">
        </form>
    </div>
    <div class="card login" style="display: none;">
        <center><h2>Login</h2></center>
        <form id="loginForm" method="get">
            <label for="loginUsername">Username:</label>
            <input type="text" id="loginUsername" name="loginUsername" required>
            <label for="loginPassword">Password:</label>
            <input type="password" id="loginPassword" name="loginPassword" required>
            <input type="submit" name="loginForm" value="Login">
        </form>
    </div>
    <div class="toggle-link">
        <a href="#" id="toggleForm">Already have an account?</a>
    </div>
</div>

<script>
    var toggleLink = document.getElementById("toggleForm");
    var registerForm = document.querySelector(".register");
    var loginForm = document.querySelector(".login");

    toggleLink.addEventListener("click", function(event) {
        event.preventDefault();
        if (registerForm.style.display === "block") {
            registerForm.style.display = "none";
            loginForm.style.display = "block";
            toggleLink.textContent = "Register"; // Changed text
        } else {
            registerForm.style.display = "block";
            loginForm.style.display = "none";
            toggleLink.textContent = "Already have an account?"; // Changed text
        }
    });
</script>

</body>
</html>

