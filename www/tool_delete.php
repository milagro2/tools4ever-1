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
?>


 
// require 'database.php';
 
// $id = $_GET['id'];
 
// $sql = "SELECT user_id FROM user_settings WHERE user_id = :id";
// $stmt = $conn->prepare($sql);
// $stmt->bindParam(":id", $id);
// $stmt->execute();
 
// if ($stmt->rowCount() > 0) {
 
//     $sql = "DELETE FROM user_settings WHERE user_id = :id";
//     $stmt = $conn->prepare($sql);
//     $stmt->bindParam(":id", $id);
//     if ($stmt->execute()) {
//         echo "Instellingen zijn verwijderd";
        
//         $sql = "DELETE FROM users WHERE id = :id";
//         $stmt = $conn->prepare($sql);
//         $stmt->bindParam(":id", $id);
//         if ($stmt->execute()) {
//             echo "Gebruiker is eindelijk verwijderd!!!";
//         }
//     }
// } 