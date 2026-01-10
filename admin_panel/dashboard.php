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
                        $number_of_deactive_products = $select_deactive_products->rowCount();
                    ?>
                    <h3><?= $number_of_deactive_products; ?></h3>
                    <p>total deactive products</p>
                    <a href="view_products.php" class="btn">deactive products</a>
                </div>
                <div class="box">
                    <?php 
                        $select_users = $conn->prepare("SELECT * FROM users");
                        $select_users->execute();
                        $number_users = $select_users->rowCount();
                    ?>
                    <h3><?= $number_users; ?></h3>
                    <p>users account</p>
                    <a href="user_accounts.php" class="btn">see users</a>
                </div>
                <div class="box">
                    <?php 
                        $select_sellers = $conn->prepare("SELECT * FROM sellers");
                        $select_sellers->execute();
                        $number_sellers = $select_sellers->rowCount();
                    ?>
                    <h3><?= $number_sellers; ?></h3>
                    <p>sellers account</p>
                    <a href="view_sellers.php" class="btn">see sellers</a>
                </div>
                <div class="box">
                    <?php 
                        $select_orders = $conn->prepare("SELECT * FROM orders WHERE seller_id=?");
                        $select_orders->execute([$seller_id]);
                        $number_of_orders = $select_orders->rowCount();
                    ?>
                    <h3><?= $number_of_orders; ?></h3>
                    <p>total orders</p>
                    <a href="admin_orders.php" class="btn">total orders</a>
                </div>
                <div class="box">
                    <?php 
                        $select_confirm_orders = $conn->prepare("SELECT * FROM orders WHERE seller_id=? AND status =?");
                        $select_confirm_orders->execute([$seller_id, "in progress"]);
                        $number_of_confirm_orders = $select_confirm_orders->rowCount();
                    ?>
                    <h3><?= $number_of_confirm_orders; ?></h3>
                    <p>total confirmed order</p>
                    <a href="admin_orders.php" class="btn">confirmed orders</a>
                </div>
                <div class="box">
                    <?php 
                        $select_canceled_orders = $conn->prepare("SELECT * FROM orders WHERE seller_id=? AND status =?");
                        $select_canceled_orders->execute([$seller_id, "canceled"]);
                        $number_of_canceled_orders = $select_canceled_orders->rowCount();
                    ?>
                    <h3><?= $number_of_canceled_orders; ?></h3>
                    <p>total canceled order</p>
                    <a href="admin_orders.php" class="btn">canceled orders</a>
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