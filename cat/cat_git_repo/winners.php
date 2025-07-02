<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Best Cat Competition</title>
<link rel="stylesheet" href="css/styles.css">
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }
    .navbar {
        background-color: #333;
        overflow: hidden;
    }
    .navbar a {
        float: left;
        display: block;
        color: #fff;
        text-align: center;
        padding: 14px 20px;
        text-decoration: none;
        font-size: 17px;
    }
    .navbar a:hover {
        background-color: #ddd;
        color: #333;
    }
    .container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
        text-align: center;
    }
    p {
        text-align: center;
    }
    .cat-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        grid-gap: 20px;
    }
    .cat {
        border-radius: 5px;
        overflow: hidden;
        position: relative;
    }
    .cat img {
        width: 100%;
        height: auto;
    }
    .vote-button {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .vote-button:hover {
        background-color: #0056b3;
    }
    .form-container {
        max-width: 600px;
        margin: 0 auto;
    }
    form {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    input[type="text"],
    input[type="email"],
    input[type="file"],
    textarea {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }
    input[type="submit"] {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 15px 20px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    input[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>

    <div class="navbar">
        <a href="/">Home</a>
        <a href="/vote.php">Vote</a>
        <a href="/contest.php">Contest</a>
        <a href="/winners.php">Winners</a>
        <?php
        if (isset($_SESSION['username'])) {
            // If user is logged in
            if ($_SESSION['username'] == 'axel') {
                // If the logged in user is admin
                echo '<a href="/admin.php">Admin</a>';
            }
            echo '<a href="/logout.php">Logout</a>';
        } else {
            // If no user is logged in
            echo '<a href="/join.php">Join</a>';
        }
        ?>
</div>

<?php
$reportsDir = 'winners/';
$files = glob($reportsDir . '*.php');
if (!empty($files)) {
    include $files[0];
} else {
    echo "<h1>There are no winners.</h1>";
}
?>


</body>
</html>

