<?php
    include '../components/connect.php';

    if(isset($_COOKIE['seller_id'])) {
        $seller_id = $_COOKIE['seller_id'];
    } else {
        $seller_id = '';
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ice Cream Delights - Dashboard Page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <?php 
        include "../include/awesome_fonts.php"; 
        include "../include/boxicons.php";
    ?>
</head>
<body>
    
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>

        <section class="dashboard">
            <div class="heading">
                <img src="../image/separator-img.png">
            </div>
            <div class="box-container">
                <div class="box">
                    <h3>welcome!</h3>
                    <p><?=  $fetch_profile['name']; ?></p>
                    <a href="update.php" class="btn">update profile</a>
                </div>
                <div class="box">
                    <?php 
                        $select_message = $conn->prepare("SELECT * FROM message");
                        $select_message->execute();
                        $number_of_message = $select_message->rowCount();
                    ?>
                    <h3><?= $number_of_message; ?></h3>
                    <p>unread messages</p>
                    <a href="admin_message.php" class="btn">see message</a>
                </div>

                <div class="box">
                    <?php 
                        $select_products = $conn->prepare("SELECT * FROM products WHERE seller_id=?");
                        $select_products->execute([$seller_id]);
                        $number_of_products = $select_products->rowCount();
                    ?>
                    <h3><?= $number_of_products; ?></h3>
                    <p>products added</p>
                    <a href="add_products.php" class="btn">add products</a>
                </div>
                <div class="box">
                    <?php 
                        $select_active_products = $conn->prepare("SELECT * FROM products WHERE seller_id=? AND status =?");
                        $select_active_products->execute([$seller_id, 'active']);
                        $number_of_active_products = $select_active_products->rowCount();
                    ?>
                    <h3><?= $number_of_active_products; ?></h3>
                    <p>total active products</p>
                    <a href="view_products.php" class="btn">active products</a>
                </div>
                <div class="box">
                    <?php 
                        $select_deactive_products = $conn->prepare("SELECT * FROM products WHERE seller_id=? AND status =?");
                        $select_deactive_products->execute([$seller_id, 'deactive']);
                        $number_of_deactive_products = $select_active_products->rowCount();
                    ?>
                    <h3><?= $number_of_deactive_products; ?></h3>
                    <p>total deactive products</p>
                    <a href="view_products.php" class="btn">deactive products</a>
                </div>
            </div>
        </section>
    </div>
<?php 
    include "../include/sweetalert.php"; 
    require "../components/alert.php";
?>
</body>
</html>