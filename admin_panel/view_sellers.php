<?php
    include "../include/init_cookie.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ice Cream Delights - Seller Accounts</title>
    <?php include "../include/include_styling.php"; ?>
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="user-container">
            <div class="heading">
                <h1>View Sellers</h1>
                <img src="../image/separator-img.png" alt="separator">
            </div>
            <div class="box-container">
                <?php 
                $select_sellers = $conn->prepare("SELECT * FROM sellers");
                $select_sellers->execute();
                if($select_sellers->rowCount() > 0) {
                    while($fetch_sellers = $select_sellers->fetch(PDO::FETCH_ASSOC)) {
                        $user_id = $fetch_sellers['id'];
                    ?>
                    <div class="box">
                        <div class="user-avatar">
                            <img src="../uploaded_files/<?= htmlspecialchars($fetch_sellers['image']); ?>" alt="Seller Avatar">
                        </div>
                        <div class="user-details">
                            <p class="user-id">Seller ID: <span><?= htmlspecialchars($user_id); ?></span></p>
                            <p class="user-name"><?= htmlspecialchars($fetch_sellers['name']); ?></p>
                            <p class="user-email">Seller Email: <span><?= htmlspecialchars($fetch_sellers['email']); ?></span></p>
                        </div>
                    </div>
                    <?php 
                    }
                } else {
                    echo '<div class="empty">
                        <p>No registered users yet!</p>
                    </div>';
                }
                ?>
            </div>
        </section>
    </div>
    <?php include "../include/include_script.php"; ?>
</body>
</html>