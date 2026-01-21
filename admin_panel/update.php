<?php
include "../include/init_cookie.php";

if(isset($_POST['submit'])) {
    $select_seller = $conn->prepare("SELECT * FROM sellers WHERE id = ? LIMIT 1");
    $select_seller->execute([$seller_id]);
    $fetch_seller = $select_seller->fetch(PDO::FETCH_ASSOC);

    $prev_pass = $fetch_seller['password'];
    $prev_img = $fetch_seller['image'];

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $old_pass = trim($_POST['old_pass']);
    $new_pass = trim($_POST['new_pass']);
    $confirm_pass = trim($_POST['confirm_pass']);

    // Update name
    if(!empty($name)) {
        if($name === $fetch_seller['name']) {
            $warning_msg[] = 'Name is the same as before!';
        } else {
            $update_name = $conn->prepare("UPDATE sellers SET name = ? WHERE id = ?");
            $update_name->execute([$name, $seller_id]);
            $success_msg[] = 'Name updated successfully!';
        }
    }

    // Update email
    if(!empty($email)) {
        $select_email = $conn->prepare("SELECT * FROM sellers WHERE id=? AND email=?");
        $select_email->execute([$seller_id, $email]);
        if($select_email->rowCount() > 0) {
            $warning_msg[] = 'Email already exist!';
        } else {
            $update_email = $conn->prepare("UPDATE sellers SET email = ? WHERE id = ?");
            $update_email->execute([$email, $seller_id]);
            $success_msg[] = 'Email updated successfully!';
        }
    }

    // Update password
    if(!empty($old_pass) && !empty($new_pass) && !empty($confirm_pass)) {
        if(!password_verify($old_pass, $prev_pass)) {
            $warning_msg[] = 'Old password is incorrect!';
        } elseif($new_pass !== $confirm_pass) {
            $warning_msg[] = 'Passwords do not match!';
        } elseif(password_verify($new_pass, $prev_pass)) {
            $warning_msg[] = 'New password is the same as old password!';
        } else {
            $hashed_pass = password_hash($new_pass, PASSWORD_ARGON2ID);
            $update_pass = $conn->prepare("UPDATE sellers SET password = ? WHERE id = ?");
            $update_pass->execute([$hashed_pass, $seller_id]);
            $success_msg[] = 'Password updated successfully!';
        }
    }

    // Update image
    if(isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        
        // Check file size
        if($image_size > 2 * 1024 * 1024) {
            $warning_msg[] = 'Image size is too large! Maximum 2MB allowed.';
        } else {
            // Rename image with unique ID
            $ext = pathinfo($image, PATHINFO_EXTENSION);
            $rename = unique_id() . '.' . $ext;
            $image_folder = '../uploaded_files/' . $rename;
            
            // Upload new image
            if(move_uploaded_file($image_tmp_name, $image_folder)) {
                // Delete old image file if it exists and is not empty
                if(!empty($prev_img) && file_exists('../uploaded_files/' . $prev_img)) {
                    unlink('../uploaded_files/' . $prev_img);
                }
                
                // Update database with new image filename
                $update_image = $conn->prepare("UPDATE sellers SET image = ? WHERE id = ?");
                $update_image->execute([$rename, $seller_id]);
                $success_msg[] = 'Profile picture updated successfully!';
            } else {
                $warning_msg[] = 'Failed to upload image!';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ice Cream Delights - Update Profile</title>
    <?php include "../include/include_styling.php"; ?>
</head>
<body>
    
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="form-container">
            <div class="heading">
                <h1>update profile</h1>
                <img src="../image/separator-img.png">
            </div>  
            <form action="" method="post" enctype="multipart/form-data" class="register" autocomplete="off">
                <div class="img-box">
                    <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" alt="<?= $fetch_profile['name']; ?> profile picture">
                </div>
                <div class="flex">
                    <div class="col">
                        <div class="input-field">
                            <p>Your name<span>*</span></p>
                            <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" class="box">
                        </div>
                        <div class="input-field">
                            <p>Your Email<span>*</span></p>
                            <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" class="box">
                        </div>
                        <div class="input-field">
                            <p>Select Profile Picture<span>*</span></p>
                            <input type="file" name="image" accept="image/*" class="box">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-field">
                            <p>Old Password<span>*</span></p>
                            <input type="password" name="old_pass" placeholder="Enter your old password..." class="box" autocomplete="off">
                        </div>
                        <div class="input-field">
                            <p>New Password<span>*</span></p>
                            <input type="password" name="new_pass" placeholder="Enter your new password..." class="box" autocomplete="new-password">
                        </div>
                        <div class="input-field">
                            <p>Confirm Password<span>*</span></p>
                            <input type="password" name="confirm_pass" placeholder="Confirm your password..." class="box" autocomplete="new-password">
                        </div>
                    </div>
                </div>
                <input type="submit" name="submit" value="update profile" class="btn">
            </form>
        </section>
    <?php include "../include/include_script.php"; ?>
</body>
</html>