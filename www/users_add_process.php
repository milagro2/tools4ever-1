<?php
session_start();

require 'database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "You are not allowed to view this page";
    exit;
}

$required_fields = ['firstname', 'lastname', 'email', 'role', 'address', 'city', 'backgroundColor', 'font', 'password'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        echo "Please fill in all fields";
        exit;
    }
}

$email = $_POST['email'];
$password = $_POST['password'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$role = $_POST['role'];
$address = $_POST['address'];
$city = $_POST['city'];
$is_active = 1;

$stmt = $conn->prepare("INSERT INTO users (email, password, firstname, lastname, role, address, city, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$email, $password, $firstname, $lastname, $role, $address, $city, $is_active]);

if ($stmt->rowCount() > 0) {
    $user_id = $conn->lastInsertId();

    $backgroundColor = $_POST['backgroundColor'];
    $font = $_POST['font'];
    $stmt = $conn->prepare("INSERT INTO user_settings (user_id, backgroundColor, font) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $backgroundColor, $font]);

    if ($stmt->rowCount() > 0) {
        header("Location: users_index.php");
        exit;
    } else {
        echo "Something went wrong";
    }
} else {
    echo "Something went wrong";
}
