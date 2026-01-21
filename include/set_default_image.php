<?php
include "init_cookie.php";

parse_str(file_get_contents('php://input'), $_POST);

if(isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $default_image = 'default-product.png';  
    
    $check_product = $conn->prepare("SELECT image FROM products WHERE id = ? AND seller_id = ?");
    $check_product->execute([$product_id, $seller_id]);
    $product = $check_product->fetch(PDO::FETCH_ASSOC);
    
    if($product && empty($product['image'])) {
        $update_image = $conn->prepare("UPDATE products SET image = ? WHERE id = ? AND seller_id = ?");
        $update_image->execute([$default_image, $product_id, $seller_id]);
    }
}
?>