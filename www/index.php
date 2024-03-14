    <?php


    echo password_hash('password', PASSWORD_DEFAULT);
    // die;


    require 'database.php';

    $sql = "SELECT * FROM tools";
    $stmt = $conn->prepare($sql);
    $stmt->execute();


    // set the resulting array to associative
    $tools = $stmt->fetchAll(PDO::FETCH_ASSOC);

    require 'header.php';
    ?>


    <main>
        <div class="container">

            <!-- show products here -->
            <?php foreach ($tools as $tool) : ?>
                <div class="product">
                    <img src="<?php echo isset($tool['tool_image']) ? 'images/' . $tool['tool_image'] : 'https://placehold.co/200' ?>" alt="<?php echo $tool['tool_name'] ?>">
                    <h3><?php echo $tool['tool_name'] ?></h3>
                    <p>€ <?php echo number_format($tool['tool_price'] / 1, 2, ',', '') ?></p>
                    <a href="tool_detail.php?id=<?php echo $tool['tool_id'] ?>">Bekijk</a>
                </div>

            <?php endforeach; ?>

        </div>

    </main>

    <?php require 'footer.php' ?>