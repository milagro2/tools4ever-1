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

require 'database.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $tool_id = $_GET['id'];

    $sql = "DELETE FROM tools WHERE tool_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$tool_id]);

    header("Location: tool_index.php");
    exit;
} else {
    echo "Invalid tool ID";
}
