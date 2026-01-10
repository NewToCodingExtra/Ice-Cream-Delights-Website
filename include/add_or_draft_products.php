<?php
    function is_published ($conn, $seller_id, &$warning_msg, &$success_msg, $yes_publish = true) {
        $mode = $yes_publish ? 'publish' : 'draft';
        if(isset($_POST[$mode])) {
            $id = unique_id();
            $name = trim($_POST['name']);
            $price = trim($_POST['price']);
            $cprice = '₱' . $price;
            $description = trim($_POST['description']);
            $stock = trim($_POST['stock']);
            $status = $yes_publish ? 'active' : 'deactive';

            $image = $_FILES['image']['name'];
            $image = trim($image);
            $image_size = $_FILES['image']['size'];
            $image_tmp_name  = $_FILES['image']['tmp_name'];
            $image_folder = '../uploaded_files/'.$image;

            $select_image = $conn->prepare("SELECT * FROM products WHERE image =? AND seller_id = ?");
            $select_image->execute([$image, $seller_id]);

            $max_size = 2 * (1024 * 1024);
            $has_error = false;

            if(isset($image)) {
                if($select_image->rowCount() > 0) {
                    $warning_msg[] = 'image name already existed!';
                    $has_error = true;
                } elseif($image_size >= $max_size) {
                    $warning_msg[] = 'image size is too large!';
                    $has_error = true;
                } else {
                    move_uploaded_file($image_tmp_name, $image_folder);
                }
            } else {
                $image = '';
                $warning_msg[] = 'Please rename your product name!';
                $has_error = true;
            }

            if(!$has_error) {
                $insert_product = $conn->prepare("INSERT INTO products (id, seller_id, name, price, image, stock, product_detail, status) VALUES (?,?,?,?,?,?,?,?)");
                $insert_product->execute([$id, $seller_id, $name, $cprice, $image, $stock, $description, $status]);
                $message = $yes_publish ? 'added' : 'drafted';
                $success_msg[] = 'product '.$message .' successfully!';
            }
        }
    }
?>