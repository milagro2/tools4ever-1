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

// Prepare and execute the SQL query
$sql = "SELECT * FROM tools";
$stmt = $conn->prepare($sql);
$stmt->execute();
$tools = $stmt->fetchAll(PDO::FETCH_ASSOC);

require 'header.php';
?>

<main>
    <table>
        <thead>
            <tr>
                <th>Naam</th>
                <th>Categorie</th>
                <th>Prijs</th>
                <th>Merk</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tools as $tool) : ?>
                <tr>
                    <td><?php echo $tool['tool_name'] ?></td>
                    <td><?php echo $tool['tool_category'] ?></td>
                    <td><?php echo $tool['tool_price'] ?></td>
                    <td><?php echo $tool['tool_brand'] ?></td>
                    <td>
                        <a href="tool_detail.php?id=<?php echo $tool['tool_id'] ?>">Bekijk</a>
                        <a href="tool_edit.php?id=<?php echo $tool['tool_id'] ?>">Wijzig</a>
                        <a href="tool_delete.php?id=<?php echo $tool['tool_id'] ?>" onclick="return confirm
                        ('Weet je zeker dat je deze tool wil Verwijderen?')">Verwijder</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require 'footer.php' ?>
