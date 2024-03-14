<?php

if (isset($_POST['submit'])) {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $emailForm = $_POST['email'];
            $passwordForm = $_POST['password'];


            require 'database.php';
            
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email ");
            $stmt->bindParam(':email', $emailForm);
            $stmt->execute();


            //als de email bestaat dan is het resultaat groter dan 0
            if ($stmt->rowCount() > 0) {

                //resultaat gevonden? Dan maken we een user-array $dbuser
                $dbuser = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($passwordForm, $dbuser['password'])) {
                // if ($dbuser['password'] == $passwordForm) {
                
                    session_start();
                    $_SESSION['user_id']    = $dbuser['id'];
                    $_SESSION['email']      = $dbuser['email'];
                    $_SESSION['firstname']  = $dbuser['firstname'];
                    $_SESSION['lastname']   = $dbuser['lastname'];
                    $_SESSION['role']       = $dbuser['role'];

                    // echo " You are logged in";
                    header("Location: dashboard.php");
                    exit;
                } else {
                    include 'header.php';
                    $_GET['message'] = 'wrongpassword';
                    include 'login-message.php';
                    include 'footer.php';
                    exit;
                }
            } else {
                include 'header.php';
                $_GET['message'] = 'usernotfound';
                include 'login-message.php';
                include 'footer.php';
                exit;
            }
        }
    }
}

include 'footer.php';
