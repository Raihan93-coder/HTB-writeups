<?php
session_start();

include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'axel') {
    header("Location: /join.php");
    exit();
}

// Get the cat_id from the URL
$cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : null;

if ($cat_id) {
    // Prepare and execute the query
    $query = "SELECT cats.*, users.username FROM cats JOIN users ON cats.owner_username = users.username WHERE cat_id = :cat_id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
    $statement->execute();

    // Fetch cat data from the database
    $cat = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$cat) {
        die("Cat not found.");
    }
} else {
    die("Invalid cat ID.");
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($cat['cat_name']); ?> - Cat Details</title>
<link rel="stylesheet" href="css/styles.css">
<style>
    .container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    .cat-photo {
        width: 100%;
        border-radius: 10px;
        margin-bottom: 10px;
    }
    .cat-info {
        font-size: 18px;
        margin-bottom: 10px;
    }
</style>
</head>
<body>

    <div class="navbar">
        <a href="/">Home</a>
        <a href="/vote.php">Vote</a>
        <a href="/contest.php">Contest</a>
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

<div class="container">
    <h1>Cat Details: <?php echo $cat['cat_name']; ?></h1>
    <img src="<?php echo $cat['photo_path']; ?>" alt="<?php echo $cat['cat_name']; ?>" class="cat-photo">
    <div class="cat-info">
        <strong>Name:</strong> <?php echo $cat['cat_name']; ?><br>
        <strong>Age:</strong> <?php echo $cat['age']; ?><br>
        <strong>Birthdate:</strong> <?php echo $cat['birthdate']; ?><br>
        <strong>Weight:</strong> <?php echo $cat['weight']; ?> kg<br>
        <strong>Owner:</strong> <?php echo $cat['username']; ?><br>
        <strong>Created At:</strong> <?php echo $cat['created_at']; ?>
    </div>
</div>

</body>
</html>

