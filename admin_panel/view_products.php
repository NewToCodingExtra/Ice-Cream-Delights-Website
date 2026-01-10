<?php
    include "../include/init_cookie.php";
    include "../include/delete_product.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ice Cream Delights - View Products</title>
    <?php include "../include/include_styling.php"; ?>
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="show-post">
            <div class="heading">
                <h1>your products</h1>
                <img src="../image/separator-img.png">
            </div>
            <div class="box-container">
                <?php 
                    $select_products = $conn->prepare("SELECT * FROM products WHERE seller_id=?");
                    $select_products->execute([$seller_id]);
                    if($select_products->rowCount() > 0) {
                        while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <form action="" method="post" class="box">
                                <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                                <?php  if($fetch_products['image'] != '') { ?>
                                    <img src="../uploaded_files/<?= $fetch_products['image']; ?>" class="image">
                                <?php } ?>
                                <div class="status" style="color: <?php if ($fetch_products['status'] == 'active') { echo 'limegreen'; } else {echo  'coral';} ?>">
                                    <?= $fetch_products['status'];?>
                                </div>
                                <div class="price"><?= $fetch_products['price']; ?>/-</div>
                                <div class="content">
                                    <img src="../image/shape-19.png" class="shap">
                                    <div class="title"> <?= $fetch_products['name']; ?></div>
                                    <div class="flex-btn">
                                        <a href="edit_product.php?id=<?= $fetch_products['id']; ?>" class="btn">edit</a>
                                        <button type="submit" name="delete" class="btn" onclick="return confirm('It will delete this product, proceed?');">delete</button>
                                        <a href="read_product.php?post_id=<?= $fetch_products['id']; ?>" class="btn">read</a>
                                    </div>
                                </div>
                            </form>
                        <?php 
                        }
                    } else {
                        echo '<div class="empty">
                            <p>no products added yet! <br> <a href="add_products.php" class="btn" style="margin-top: 1.5rem;">add products</a></p>
                        </div>';
                    }
                ?>
            </div>
        </section>
    </div>

    <?php include "../include/include_script.php"; ?>
    
</body>
</html>