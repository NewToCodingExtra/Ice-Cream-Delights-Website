<?php
    include "../include/init_cookie.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ice Cream Delights - Update Seller Profile</title>
    <?php include "../include/include_styling.php"; ?>
</head>
<body>
    
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="seller-profile">
            <div class="post-editor">
                <div class="heading">
                    <h1>update profile</h1>
                    <img src="../image/separator-img.png">
                </div>    

                <div class="details">
                    <div class="seller">
                        <img src="../uploaded_files/<?= $fetch_profile['image']; ?>">
                        <h3 class="name"><?= $fetch_profile['name']; ?></h3>
                        <span>Seller</span>
                        <a href="profile.php" class="btn">Profile</a>
                    </div>
                    
                    </div>
                </div>
            </div>
        </section>
    <?php include "../include/include_script.php"; ?>
</body>
</html>