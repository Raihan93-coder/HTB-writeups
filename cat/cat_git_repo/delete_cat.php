<?php
include 'config.php';
session_start();

if (isset($_SESSION['username']) && $_SESSION['username'] == 'axel'){
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['catId'])) {
        $catId = $_POST['catId'];

        $stmt_select = $pdo->prepare("SELECT photo_path FROM cats WHERE cat_id = :cat_id");
        $stmt_select->bindParam(':cat_id', $catId, PDO::PARAM_INT);
        $stmt_select->execute();
        $cat = $stmt_select->fetch(PDO::FETCH_ASSOC);

        if ($cat) {
            $photo_path = $cat['photo_path'];

            $stmt_delete = $pdo->prepare("DELETE FROM cats WHERE cat_id = :cat_id");
            $stmt_delete->bindParam(':cat_id', $catId, PDO::PARAM_INT);
            $stmt_delete->execute();

            if (file_exists($photo_path)) {
                unlink($photo_path);
            }

            echo "The cat has been rejected and removed successfully.";
        } else {
            echo "Error: Cat not found.";
        }
    } else {
        echo "Error: Cat ID not provided.";
    }
 } else {
    header("Location: /");
    exit();
 }
 } else {
    echo "Access denied.";
 }
?>

