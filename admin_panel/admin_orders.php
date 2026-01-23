<?php
    include "../include/init_cookie.php";

    if(isset($_POST['update_order'])) {
        $order_id = trim($_POST['order_id']);
        $update_payment = trim($_POST['update_payment']);
        $update_pay = $conn->prepare("UPDATE orders SET payment_status = ? WHERE id = ?");
        $update_pay->execute([$update_payment, $order_id]);
        $success_msg[] = 'Order payment status updated!';
    }

    if(isset($_POST['delete_order'])) {
        $delete_id = trim($_POST['order_id']);
        $verify_delete = $conn->prepare("SELECT * FROM orders WHERE id = ?");
        $verify_delete->execute([$delete_id]);

        if($verify_delete->rowCount() > 0) {
            $delete_order  = $conn->prepare("DELETE FROM orders WHERE id = ?");
            $delete_order->execute([$delete_id]);
            $success_msg[] = 'Order deleted successfully!';
        } else {
            $warning_msg[] = 'Something went wrong!, can\'t delete or already deleted the order.';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ice Cream Delights - Order Page</title>
    <?php include "../include/include_styling.php"; ?>
</head>
<body>
    
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="order-container">
            <div class="heading">
                <h1>Active Orders</h1>
                <img src="../image/separator-img.png">
            </div>
            <div class="box-container">
                <?php 
                    $select_order = $conn->prepare("
                        SELECT 
                            o.*, 
                            p.name AS product_name,
                            p.price AS unit_price
                        FROM orders o
                        JOIN products p ON o.product_id = p.id
                        WHERE o.seller_id = ?
                    ");
                    $select_order->execute([$seller_id]);

                    if($select_order->rowCount() > 0) {
                        while($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <div class="box">
                        <div class="status" style="color: <?php if($fetch_order['status'] == 'in progress') echo 'limegreen'; else echo 'red'; ?>">
                            <?= $fetch_order['status'] ?>
                        </div>
                        <div class="detail">
                            <p>user name: <span><?= $fetch_order['name'] ?></span></p>
                            <p>user id: <span><?= $fetch_order['user_id'] ?></span></p>
                            <p>placed on: <span><?= $fetch_order['date'] ?></span></p>
                            <p>user number: <span><?= $fetch_order['number'] ?></span></p>
                            <p>product ordered: <span><?= $fetch_order['product_name'] ?></span></p>
                            <p>unit price: <span>₱<?= number_format((float)str_replace('₱', '', $fetch_order['unit_price']), 2); ?></span></p>
                            <p>quantity: <span><?= $fetch_order['qty'] ?></span></p>
                            <p>total price: <span>₱<?= number_format($fetch_order['price'], 2); ?></span></p>
                            <p>payment method: <span><?= $fetch_order['method'] ?></span></p>
                            <p>user address: <span><?= $fetch_order['address'] ?></span></p>
                        </div>
                        <form action="" method="post">
                            <input type="hidden" name="order_id" value="<?= $fetch_order['id'] ?>">
                            <select name="update_payment" class="box" style="width: 90%;">
                                <option disabled selected><?= $fetch_order['payment_status']; ?></option>
                                <option value="peding">pending</option>
                                <option value="order delivered">Order Delivered</option>
                            </select>
                            <div class="flex-btn">
                                <input type="submit" name="update_order" value="Update payment" class="btn">
                                <input type="submit" name="delete_order" value="Delete payment" class="btn" onclick="return confirm('Delete this order?');">
                            </div>
                        </form>
                    </div>
                    <?php
                        }
                    } else {
                        echo '<div class="empty">
                                <p>No order placed yet!</p>
                            </div>';
                    }
                ?>
            </div>
        </section>
    </div>

    <?php include "../include/include_script.php"; ?>
</body> 
</html>