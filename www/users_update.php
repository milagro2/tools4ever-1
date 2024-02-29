<?php

// echo"<pre>";
// print_r($_POST);
// echo "</pre>";

$firstname =    $_POST['firstname'];
$lastname =     $_POST['lastname'];
$password =     $_POST['password'];
$email =        $_POST['email'];
$address =      $_POST['address'];
$city =         $_POST['city'];
$role =         $_POST['role'];
$id =           $_POST['user_id'];

require 'database.php';

$sql = "UPDATE users SET firstname = :firstname,
 lastname = :lastname,
  password = :password,
   email = :email,
    address = :address,
    city = :city,
    role = :role
    WHERE id = :id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(":firstname", $firstname);
$stmt->bindParam(":lastname", $lastname);
$stmt->bindParam(":password", $password);
$stmt->bindParam(":email", $email);
$stmt->bindParam(":address", $address);
$stmt->bindParam(":city", $city);
$stmt->bindParam(":role", $role);
$stmt->bindParam(":id", $id);

if ($stmt->execute()) {
    echo "user has been updated";
}