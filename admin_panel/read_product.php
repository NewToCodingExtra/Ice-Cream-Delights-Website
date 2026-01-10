<?php
    include "../include/init_cookie.php";
    include "../include/delete_product.php";

    $get_id = $_GET['post_id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ice Cream Delights - Read Products</title>
    <?php include "../include/include_styling.php"; ?>
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="read-post">
            <div class="heading">
                <h1>product detail</h1>
                <img src="../image/separator-img.png">
            </div>
            <div class="box-container">
                <?php 
                    $select_product = $conn->prepare("SELECT * FROM products WHERE id =? AND seller_id=? ");
                    $select_product->execute([$get_id, $seller_id]);

                    if($select_product->rowCount() > 0) {
                        while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <form action="" method="post" class="box">
                                <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
                                <div class="status" style="color: <?php if ($fetch_product['status'] == 'active') { echo 'limegreen'; } else {echo  'coral';} ?>">
                                    <?= $fetch_product['status'];?>
                                </div>
                                <?php  if($fetch_product['image'] != '') { ?>
                                    <img src="../uploaded_files/<?= $fetch_product['image']; ?>" class="image">
                                <?php } ?>
                                <div class="price"><?= $fetch_product['price']; ?>/-</div>
                                <div class="title"> <?= $fetch_product['name']; ?></div>
                                <div class="content"><?= $fetch_product['product_detail']; ?></div>

                                <div class="flex-btn">
                                    <a href="edit_product.php?id=<?= $fetch_products['id']; ?>" class="btn">edit</a>
                                    <button type="submit" name="delete" class="btn" onclick="return confirm('It will delete this product, proceed?');">delete</button>
                                    <a href="view_products.php" class="btn">go back</a>
                                </div>
                            </form>
                            <?php 
                        }
                    } else {
                        ?>
                         <div class="empty">
                            <p>no products added yet! <br> <a href="add_products.php" class="btn" style="margin-top: 1.5rem;">add products</a></p>
                        </div>
                        <?php 
                    }
                ?>
            </div>
        </section>
    </div>

    <?php 
        include "../include/include_script.php";
        include "../include/show_alert_for_products.php";
    ?>
</body>
</html>