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

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Tool ID is missing";
    exit;
}

$tool_id = $_GET['id'];
$sql = "SELECT * FROM tools WHERE tool_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$tool_id]);
$tool = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tool) {
    echo "Tool not found";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $brand = $_POST['brand'];

    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $image_temp = $_FILES['image']['tmp_name'];
        $image_folder = "images/";

        if (move_uploaded_file($image_temp, $image_folder . $image)) {
            $sql = "UPDATE tools SET tool_name = ?, tool_category = ?, tool_price = ?, tool_brand = ?, tool_image = ? WHERE tool_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$name, $category, $price, $brand, $image, $tool_id]);
        } else {
            echo "Failed to upload image";
        }
    } else {
        $sql = "UPDATE tools SET tool_name = ?, tool_category = ?, tool_price = ?, tool_brand = ? WHERE tool_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $category, $price, $brand, $tool_id]);
    }

    if ($stmt->rowCount() > 0) {
        header("Location: tool_index.php");
        exit;
    } else {
        echo "Failed to update tool";
    }
}

require 'header.php';
?>

<main>
    <h1>Wijzig Gereedschap</h1>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <div>
                <label for="name">Naam:</label>
                <input type="text" id="name" name="name" value="<?php echo $tool['tool_name']; ?>">
            </div>
            <div>
                <label for="category">Categorie:</label>
                <input type="text" id="category" name="category" value="<?php echo $tool['tool_category']; ?>">
            </div>
            <div>
                <label for="price">Prijs:</label>
                <input type="number" id="price" name="price" value="<?php echo $tool['tool_price']; ?>">
            </div>
            <div>
                <label for="brand">Merk:</label>
                <input type="text" id="brand" name="brand" value="<?php echo $tool['tool_brand']; ?>">
            </div>
            <div>
                <label for="image">Afbeelding:</label>
                <input type="file" id="image" name="image">
                <img src="images/<?php echo $tool['tool_image']; ?>" alt="Current Image" style="max-width: 200px;">
            </div>
            <button type="submit" class="btn btn-success">Opslaan</button>
        </form>
    </div>
</main>

<?php require 'footer.php' ?>