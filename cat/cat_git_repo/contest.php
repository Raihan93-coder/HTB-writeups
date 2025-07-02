<?php
session_start();

include 'config.php';

// Message variables
$success_message = "";
$error_message = "";

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: /join.php");
    exit();
}

// Function to check for forbidden content
function contains_forbidden_content($input, $pattern) {
    return preg_match($pattern, $input);
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $cat_name = $_POST['cat_name'];
    $age = $_POST['age'];
    $birthdate = $_POST['birthdate'];
    $weight = $_POST['weight'];

    $forbidden_patterns = "/[+*{}',;<>()\\[\\]\\/\\:]/";

    // Check for forbidden content
    if (contains_forbidden_content($cat_name, $forbidden_patterns) ||
        contains_forbidden_content($age, $forbidden_patterns) ||
        contains_forbidden_content($birthdate, $forbidden_patterns) ||
        contains_forbidden_content($weight, $forbidden_patterns)) {
        $error_message = "Your entry contains invalid characters.";
    } else {
        // Generate unique identifier for the image
        $imageIdentifier = uniqid() . "_";

        // Upload cat photo
        $target_dir = "uploads/";
        $target_file = $target_dir . $imageIdentifier . basename($_FILES["cat_photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an actual image or a fake file
        $check = getimagesize($_FILES["cat_photo"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $error_message = "Error: The file is not an image.";
            $uploadOk = 0;
        }

        // Check if the file already exists
        if (file_exists($target_file)) {
            $error_message = "Error: The file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["cat_photo"]["size"] > 500000) {
            $error_message = "Error: The file is too large.";
            $uploadOk = 0;
        }

        // Allow only certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $error_message = "Error: Only JPG, JPEG, and PNG files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
        } else {
            if (move_uploaded_file($_FILES["cat_photo"]["tmp_name"], $target_file)) {
                // Prepare SQL query to insert cat data
                $stmt = $pdo->prepare("INSERT INTO cats (cat_name, age, birthdate, weight, photo_path, owner_username) VALUES (:cat_name, :age, :birthdate, :weight, :photo_path, :owner_username)");
                // Bind parameters
                $stmt->bindParam(':cat_name', $cat_name, PDO::PARAM_STR);
                $stmt->bindParam(':age', $age, PDO::PARAM_INT);
                $stmt->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
                $stmt->bindParam(':weight', $weight, PDO::PARAM_STR);
                $stmt->bindParam(':photo_path', $target_file, PDO::PARAM_STR);
                $stmt->bindParam(':owner_username', $_SESSION['username'], PDO::PARAM_STR);
                // Execute query
                if ($stmt->execute()) {
                    $success_message = "Cat has been successfully sent for inspection.";
                } else {
                    $error_message = "Error: There was a problem registering the cat.";
                }
            } else {
                $error_message = "Error: There was a problem uploading the file.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contest - Best Cat Community</title>
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
    form {
        padding: 20px;
        box-sizing: border-box;
    }
    label,
    input {
        display: block;
        margin-bottom: 10px;
        width: 100%;
    }
    input[type="submit"] {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 15px 20px;
        cursor: pointer;
        transition: background-color 0.3s;
        width: 100%;
    }
    input[type="submit"]:hover {
        background-color: #0056b3;
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
        <?php
        if (isset($_SESSION['username'])) {
            // If the user is logged in
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
        <h1>Contest - Best Cat Community</h1>
        <?php if ($success_message): ?>
            <div class="message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <label for="cat_name">Cat Name:</label>
            <input type="text" id="cat_name" name="cat_name" required>
            <label for="age">Cat Age:</label>
            <input type="number" id="age" name="age" required>
            <label for="birthdate">Cat Birthdate:</label>
            <input type="date" id="birthdate" name="birthdate" required>
            <label for="weight">Cat Weight (in kg):</label>
            <input type="number" id="weight" name="weight" step="0.01" required>
            <label for="cat_photo">Cat Photo:</label>
            <input type="file" id="cat_photo" name="cat_photo" accept="image/*" required>
            <input type="submit" value="Register Cat">
        </form>
    </div>

</body>
</html>

