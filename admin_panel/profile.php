<?php
    include "../include/init_cookie.php";

    $select_products = $conn->prepare("SELECT * FROM products WHERE seller_id = ?");
    $select_products->execute([$seller_id]);
    $total_products = $select_products->rowCount();

    $select_orders = $conn->prepare("SELECT * FROM orders WHERE seller_id = ?");
    $select_orders->execute([$select_id]);
    $total_orders = $select_orders->rowCount();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ice Cream Delights - Seller Profile</title>
    <?php include "../include/include_styling.php"; ?>
</head>
<body>
    
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="seller-profile">
            <div class="post-editor">
                <div class="heading">
                    <h1>my profile details</h1>
                    <img src="../image/separator-img.png">
                </div>    

                <div class="details">
                    <div class="seller">
                        <img src="../uploaded_files/<?= $fetch_profile['image']; ?>">
                        <h3 class="name"><?= $fetch_profile['name']; ?></h3>
                        <span>Seller</span>
                        <a href="update.php" class="btn">Update Profile</a>
                    </div>
                    <div class="flex">
                        <div class="box">
                            <span><?= $total_products; ?></span>
                            <p>Total Products</p>
                            <a href="view_products.php" class="btn">View Products</a>
                        </div>
                        <div class="box">
                            <span><?= $total_orders; ?></span>
                            <p>Total Order Placed</p>
                            <a href="admin_order.php" class="btn">View Orders</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php include "../include/include_script.php"; ?>
</body>
</html>