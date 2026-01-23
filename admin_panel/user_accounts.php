<?php
    include "../include/init_cookie.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ice Cream Delights - User Accounts</title>
    <?php include "../include/include_styling.php"; ?>
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="user-container">
            <div class="heading">
                <h1>Registered Users</h1>
                <img src="../image/separator-img.png" alt="separator">
            </div>
            <div class="box-container">
                <?php 
                $select_users = $conn->prepare("SELECT * FROM users");
                $select_users->execute();
                if($select_users->rowCount() > 0) {
                    while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)) {
                        $user_id = $fetch_users['user_id'];
                    ?>
                    <div class="box">
                        <div class="user-avatar">
                            <img src="../uploaded_files/<?= htmlspecialchars($fetch_users['image']); ?>" alt="User Avatar">
                        </div>
                        <div class="user-details">
                            <p class="user-id">User ID: <span><?= htmlspecialchars($user_id); ?></span></p>
                            <p class="user-name"></Name:span><?= htmlspecialchars($fetch_users['name']); ?></p>
                            <p class="user-email">User Email: <span><?= htmlspecialchars($fetch_users['email']); ?></span></p>
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