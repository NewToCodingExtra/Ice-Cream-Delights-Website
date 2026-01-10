<?php
    include "../include/init_cookie.php";
    include "../include/add_or_draft_products.php";
    //add product to the db
    if(isset($_POST['publish'])) {
        is_published($conn, $seller_id, $warning_msg, $success_msg);
    }
    //draft product to the db
    if(isset($_POST['draft'])) {
        is_published($conn, $seller_id, $warning_msg, $success_msg, false);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Icce Cream Delights - Add Products</title>
    <?php include "../include/include_styling.php"; ?>
</head>
<body>
    
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <div class="post-editor">
            <div class="heading">
                <h1>add product</h1>
                <img src="../image/separator-img.png">
            </div>
            <div class="form-container">
                <form action="" method="post" enctype="multipart/form-data" class="register">
                    <div class="input-field">
                        <p>product name<span>*</span></p>
                        <input type="text" name="name" maxlength="100" placeholder="add product name" required class="box">
                    </div>
                    <div class="input-field">
                        <p>product price (₱)<span>*</span></p>
                        <input type="number" name="price" maxlength="100" placeholder="add product price" required class="box">
                    </div>
                    <div class="input-field">
                        <p>product details<span>*</span></p>
                        <textarea name="description" required maxlength="1000" placeholder="add a product description" class="box"></textarea>
                    </div>
                    <div class="input-field">
                        <p>product stock<span>*</span></p>
                        <input type="number" name="stock" maxlength="10" min="0" max="9999999999" placeholder="add product stock" required class="box">
                    </div>
                    <div class="input-field">
                        <p>product image<span>*</span></p>
                        <input type="file" name="image" accept="image/*" required class="box">
                    </div>
                    <div class="flex-btn">
                        <input type="submit" name="publish" value="add product" class="btn">
                        <input type="submit" name="draft" value="save as draft" class="btn">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include "../include/include_script.php"; ?>
</body>
</html>