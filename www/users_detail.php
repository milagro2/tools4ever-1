<?php
    session_start();
    require 'database.php';

    $sql = "SELECT * FROM users";

    require 'header.php';
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // set the resulting array to associative
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ?>

<main>
    <div class="container">
        <?php if (isset($user)) : ?>
            <div class="user-detail">
                <h3><?php echo $user['firstname'] ?></h3>
                <p><?php echo $user['lastname'] ?></p>
                <p><?php echo $user['email'] ?></p>
                <p><?php echo $user['role'] ?></p>
                <p><?php echo $user['address'] ?></p>
                <p><?php echo $user['city'] ?></p>
                <p><?php echo $user['is_active'] == 1 ? "is actief" : "Is niet actief"  ?></p>
                <p><?php echo $user['backgroundColor'] ?></p>
                <p><?php echo $user['font'] ?></p>
            <?php else : ?>
                Geen gebruiker gevonden
            <?php endif; ?>
</main>
<?php require 'footer.php' ?>