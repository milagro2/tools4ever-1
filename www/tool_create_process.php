<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You are not logged in, please login. ";
    echo "<a href='login.php'>Login here</a>";
    exit;
}

if ($_SESSION['role'] != 'admin') {
    echo "You are not allowed to view this page, please login as admin";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "You are not allowed to view this page";
    exit;
}

require 'database.php';

$name = $_POST['name'];
$category = $_POST['category'];
$price = $_POST['price'];
$brand = $_POST['brand'];


$image = $_FILES['image']['name'];
$image_temp = $_FILES['image']['tmp_name'];
$image_folder = "images/";


if (move_uploaded_file($image_temp, $image_folder . $image)) {
    $sql = "INSERT INTO tools (tool_name, tool_category, tool_price, tool_brand, tool_image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$name, $category, $price, $brand, $image]);

    if ($stmt->rowCount() > 0) {
        header("Location: tool_index.php");
        exit;
    } else {
        echo "Failed to insert tool into database";
    }
} else {
    echo "Failed to upload image";
}
?>
