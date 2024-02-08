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

require 'header.php';
require 'database.php';

// Fetch data using PDO
$sql = "SELECT COUNT(id) AS total FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();
$users = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT COUNT(id) AS total FROM users WHERE role = 'employee'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$employees = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT COUNT(tool_id) AS total FROM tools";
$stmt = $conn->prepare($sql);
$stmt->execute();
$tools = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<main class="dashboard">
    <h1>Dashboard</h1>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Welkom <?php echo $_SESSION['firstname'] ?></h2>
                <p>Je bent ingelogd als <?php echo $_SESSION['role'] ?></p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-group">
                <h2>Totaal aantal gebruikers</h2>
                <p><?php echo $users['total'] ?></p>
            </div>
            <div class="card-group">
                <h2>Totaal aantal medewerkers</h2>
                <p><?php echo $employees['total'] ?></p>
            </div>
            <div class="card-group">
                <h2>Totaal aantal soorten gereedschap</h2>
                <p><?php echo $tools['total'] ?></p>
            </div>
        </div>
    </div>
</main>

<?php require 'footer.php' ?>
