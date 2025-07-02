<?php
session_start();

include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'axel') {
    header("Location: /join.php");
    exit();
}

// Fetch cat data from the database
$stmt = $pdo->prepare("SELECT * FROM cats");
$stmt->execute();
$cats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Cats - Best Cat Community</title>
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
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
    .cat-card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
        position: relative;
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
    .view-button, .accept-button, .reject-button {
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .view-button {
        background-color: #007bff;
        color: white;
    }
    .accept-button {
        background-color: #4caf50;
        color: white;
        margin-right: 10px;
    }
    .reject-button {
        background-color: #f44336;
        color: white;
        margin-right: 10px;
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
                echo '<a href="/winners.php">Winners</a>';
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
    <h1>My Cats</h1>
    <?php foreach ($cats as $cat): ?>
        <div class="cat-card">
            <img src="<?php echo htmlspecialchars($cat['photo_path']); ?>" alt="<?php echo htmlspecialchars($cat['cat_name']); ?>" class="cat-photo">
            <div class="cat-info">
                <strong>Name:</strong> <?php echo htmlspecialchars($cat['cat_name']); ?><br>
            </div>
            <button class="view-button" onclick="window.location.href='/view_cat.php?cat_id=<?php echo htmlspecialchars($cat['cat_id']); ?>'">View</button>
            <button class="accept-button" onclick="acceptCat('<?php echo htmlspecialchars($cat['cat_name']); ?>', <?php echo htmlspecialchars($cat['cat_id']); ?>)">Accept</button>
            <button class="reject-button" onclick="rejectCat(<?php echo htmlspecialchars($cat['cat_id']); ?>)">Reject</button>
        </div>
    <?php endforeach; ?>
</div>

<script>
    function acceptCat(catName, catId) {
       if (confirm("Are you sure you want to accept this cat?")) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "accept_cat.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    window.location.reload();
                }
            };
            xhr.send("catName=" + encodeURIComponent(catName) + "&catId=" + catId);
        }
    }

    function rejectCat(catId) {
        if (confirm("Are you sure you want to reject this cat?")) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_cat.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    window.location.reload();
                }
            };
            xhr.send("catId=" + catId);
        }
    }
</script>

</body>
</html>

