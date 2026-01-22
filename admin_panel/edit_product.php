<?php
    include "../include/init_cookie.php";

    if(isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
    } elseif(isset($_GET['product_id'])) {
        $product_id = $_GET['id'];
    } else {
        $product_id = '';
    }

    if(isset($_POST['update'])) {
        $product_id = $_POST['product_id'];
        $old_image = $_POST['old_image'];
        
        $name = trim($_POST['name']);
        $price = trim($_POST['price']);
        $cprice = '₱' . $price;
        $description = trim($_POST['description']);
        $stock = trim($_POST['stock']);
        $status = $_POST['status'];
        
        $update_product = $conn->prepare("UPDATE products SET name = ?, price = ?, product_detail = ?, stock = ?, status = ? WHERE id = ? AND seller_id = ?");
        $update_product->execute([$name, $cprice, $description, $stock, $status, $product_id, $seller_id]);
        
        $success_msg[] = 'Product updated successfully!';
        
        if(isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $image = trim($_FILES['image']['name']);
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_size = $_FILES['image']['size'];
            $image_folder = '../uploaded_files/' . $image;
            
            $max_size = 2 * 1024 * 1024;
            
            if(empty($image)) {
                $warning_msg[] = 'Please provide a valid image filename!';
            }
            elseif($image_size > $max_size) {
                $warning_msg[] = 'Image size is too large! Maximum 2MB allowed.';
            }
            elseif($image === $old_image) {
                $warning_msg[] = 'This is already your current product image!';
            } else {
                $select_image = $conn->prepare("SELECT * FROM products WHERE image = ? AND seller_id = ? AND id != ?");
                $select_image->execute([$image, $seller_id, $product_id]);
                
                if($select_image->rowCount() > 0) {
                    $warning_msg[] = 'Image name already exists! Please rename your file.';
                } else {
                    if(move_uploaded_file($image_tmp_name, $image_folder)) {
                        if(!empty($old_image) && $old_image !== 'default-product.png' && file_exists('../uploaded_files/' . $old_image)) {
                            unlink('../uploaded_files/' . $old_image);
                        }
                        
                        $update_image = $conn->prepare("UPDATE products SET image = ? WHERE id = ? AND seller_id = ?");
                        $update_image->execute([$image, $product_id, $seller_id]);
                        
                        $success_msg[] = 'Product image updated successfully!';
                    }
                }
            }
        }
    }

    if(isset($_POST['delete_image'])) {
        $product_id = $_POST['product_id'];
        $old_image = $_POST['old_image'];
        
        if(!empty($old_image) && $old_image !== 'default-product.png' && file_exists('../uploaded_files/' . $old_image)) {
            unlink('../uploaded_files/' . $old_image);
        }
        
        $delete_image = $conn->prepare("UPDATE products SET image = ? WHERE id = ? AND seller_id = ?");
        $delete_image->execute(['', $product_id, $seller_id]);
        
        $success_msg[] = 'Product image reset to default!';
    }

    include "../include/delete_product.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ice Cream Delights - Edit Product</title>
    <?php include "../include/include_styling.php"; ?>
</head>
<body>
    
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="post-editor">
            <div class="heading">
                <h1>edit product</h1>
                <img src="../image/separator-img.png">
            </div>
            <div class="box-container">
                <?php
                    $product_id = $_GET['id'];
                    $select_product = $conn->prepare("SELECT * FROM products WHERE id=? AND seller_id = ?");
                    $select_product->execute([$product_id, $seller_id]);
                    
                    if($select_product->rowCount() > 0) {
                        while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <div class="form-container">
                                <form action="" method="post" enctype="multipart/form-data" class="register">
                                    <input type="hidden" name="old_image" value="<?= $fetch_product['image'] ?>">
                                    <input type="hidden" name="product_id" value="<?= $fetch_product['id'] ?>">
                                    <div class="input-field">
                                        <p>product status<span>*</span></p>
                                        <select name="status" class="box">
                                            <option value="<?= $fetch_product['status']; ?>" selectd><?= $fetch_product['status']; ?></option>
                                            <option value="active">active</option>
                                            <option value="deactive">deactive</option>
                                        </select>
                                    </div>
                                    <div class="input-field">
                                        <p>product name<span>*</span></p>
                                        <input type="text" name="name" maxlength="100" value="<?= $fetch_product['name']; ?>" class="box">
                                    </div>
                                    <div class="input-field">
                                        <p>product price (₱)<span>*</span></p>
                                        <input type="number" name="price" maxlength="100" value="<?= str_replace('₱', '', $fetch_product['price']); ?>" class="box">
                                    </div>
                                    <div class="input-field">
                                        <p>product details<span>*</span></p>
                                        <textarea name="description" maxlength="1000" class="box"><?= $fetch_product['product_detail']; ?></textarea>
                                    </div>
                                    <div class="input-field">
                                        <p>product stock<span>*</span></p>
                                        <input type="number" name="stock" maxlength="10" min="0" max="9999999999" value="<?= $fetch_product['stock']; ?>" class="box">
                                    </div>
                                    <div class="input-field">
                                        <p>product image<span>*</span></p>
                                        <input type="file" name="image" accept="image/*" class="box">
                                        <?php 
                                            if($fetch_product['image'] != '') {?>
                                                <img src="../uploaded_files/<?= $fetch_product['image']; ?>" class="image">
                                            <div class="flex-btn">
                                                <input type="submit" name="delete_image" class="btn" value="delete image" id="delete-image-btn">
                                                <a href="view_products.php" class="btn" style="width: 49%; text-align: center; height: 3rem; margin-top: .7rem;">go back</a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="flex-btn">
                                        <input type="submit" name="update"  class="btn" value="update product" >
                                        <input type="submit" name="delete" class="btn" value="delete product" id="delete-product-btn">
                                    </div>
                                </form>
                                <?php 
                                }
                            } else {
                                echo '<div class="empty">
                                    <p>no products added yet! <br> <a href="add_products.php" class="btn" style="margin-top: 1.5rem;">add products</a></p>
                                </div>';
                            } ?>
                            </div>
            </div>      
        </section>
    </div>
    <?php include "../include/include_script.php"; include "../include/show_alert_for_products.php"; ?>
</body>
</html>