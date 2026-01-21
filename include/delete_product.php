<?php

if(isset($_POST['delete'])) {
    $p_id = trim($_POST['product_id']);

    $delete_image = $conn->prepare("SELECT * FROM products WHERE id=? AND seller_id=?");
    $delete_image->execute([$p_id, $seller_id]);
    $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);

    if($fetch_delete_image && $fetch_delete_image['image'] !== 'default-product.png' && $fetch_delete_image['image'] != '') {
        $image_path = '../uploaded_files/' . $fetch_delete_image['image'];
        if(file_exists($image_path)) {
            unlink($image_path);
        }
    }

    $delete_product = $conn->prepare("DELETE FROM products WHERE id=? AND seller_id=?");
    $delete_product->execute([$p_id, $seller_id]);

    $success_msg[] = 'Product successfully deleted!';
    $redirect_after_delete = true; // Flag for redirect
}
?>