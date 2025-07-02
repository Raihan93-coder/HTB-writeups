<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vote for Your Favorite Cat</title>
<link rel="stylesheet" href="css/styles.css">
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
            if ($_SESSION['username'] === 'axel') {
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

    <div class="container">
        <h1>Vote for Your Favorite Cat</h1>
        <div class="cat-gallery">
            <div class="cat">
                <img src="img/cat1.jpg" alt="Cat 1">
                <br><br><br><br>
                <button class="vote-button">Vote</button>
            </div>
            <div class="cat">
                <img src="img/cat2.png" alt="Cat 2">
                <button class="vote-button">Vote</button>
            </div>
            <div class="cat">
                <img src="img/cat3.webp" alt="Cat 3">
                <button class="vote-button">Vote</button>
            </div>
        </div>
        <h1><center><span style="color: red; font-style: italic;">Voting is currently closed</span></center></h1>
    </div>

</body>
</html>

