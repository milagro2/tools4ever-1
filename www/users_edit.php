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

$id = $_GET['id'];
 
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();
 if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
 

} else {
    echo"Geen gebruiker gevonden met deze ID <br>";
    echo"<a href='users_index.php'>Ga terug!! <br>";
}

require 'header.php';

?>

<main>
    <div class="container">
        <form action="users_update.php" method="post">
            <input type="hidden" name="user_id" value="<?php echo $user['id'] ?>">
            <div>
                <label for="firstname">Voornaam:</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo $user['firstname'] ?>">
            </div>
            <div>
                <label for="lastname">Achternaam:</label>
                <input type="text" id="lastname" name="lastname"value="<?php echo $user['lastname'] ?>">
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email'] ?>">
            </div>
            <div>
                <label for="password">Wachtwoord:</label>
                <input type="password" id="password" name="password"value="<?php echo $user['password'] ?>">
            </div>
            <div>
                <label for="address">Adres:</label>
                <input type="text" id="address" name="address"value="<?php echo $user['address'] ?>">
            </div>
            <div>
                <label for="city">Stad:</label>
                <input type="text" id="city" name="city" value="<?php echo $user['city'] ?>">
            </div>

            <div>
                <label for="role">Rol:</label>
                <select id="role" name="role" value="<?php echo $user['role'] ?>">
                    <!-- <option value="<?php echo $user['role']?>>" -->
                    <option value="">Selecteer Rol</option>
                    <option value="admin">Admin</option>
                    <option value="employee">Werknemer</option>
                </select>
            </div>

            <input type="submit" value="Edit user">
        </form>
    </div>
</main>
<?php require 'footer.php' ?>