<?php
include "../components/connect.php";

if(isset($_POST['submit'])) {
    $id = unique_id();

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['pass']);
    $cpass = trim($_POST['cpass']);

    if($password !== $cpass){
        $warning_msg[] = "Confirm password does not match";
    } else {
        $hashed_password = password_hash($cpass, PASSWORD_ARGON2ID);

        // Handle image
        $image = $_FILES['image']['name'];
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = unique_id() . '.' . $ext;
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = "../uploaded_files/" . $rename;

        // Check if email exists
        $select_seller = $conn->prepare("SELECT * FROM sellers WHERE email = ?");
        $select_seller->execute([$email]);

        if($select_seller->rowCount() > 0){
            $warning_msg[] = "Email already exists";
        } else {
            $insert_seller = $conn->prepare(
                "INSERT INTO sellers (id, name, email, password, image) VALUES (?, ?, ?, ?, ?)"
            );
            

            if($insert_seller->execute([$id, $name, $email, $hashed_password, $rename])){
                move_uploaded_file($image_tmp_name, $image_folder);
                $success_msg[] = "Registered successfully!";
            } else {
                $error_msg[] = "Registration failed!";
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
    <title>Ice Cream Delights - Registration Page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <?php include "../include/awesome_fonts.php"; ?>
</head>
<body>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="register">
            <h2>Register Now</h2>
            <div class="flex">
                <div class="col">
                    <div class="input-field">
                        <p>Your Name <span>*</span></p>
                        <input type="text" name="name" placeholder="Enter your name..." maxlength="50" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Your Email <span>*</span></p>
                        <input type="text" name="email" placeholder="Enter your email..." maxlength="50" required class="box">
                    </div>
                </div>

                <div class="col">
                    <div class="input-field">
                        <p>Your Password <span>*</span></p>
                        <input type="password" name="pass" placeholder="Enter your password..." maxlength="50" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Confirm Password <span>*</span></p>
                        <input type="password" name="cpass" placeholder="Confirm your password..." maxlength="50" required class="box">
                    </div>
                </div>
            </div>
            <div class="input-field">
                <p> Your Picture <span>*</span> </p>
                <input type="file" name="image" accept="image/*" required class="box">
            </div>

            <p class="link">Already have an account? <a href="login.php">login now</a></p>

            <input type="submit" name="submit" value="register now" class="btn">
        </form>
    </div>

    <?php 
        include "../include/sweetalert.php"; 
        require "../components/alert.php";
    ?>
</body>
</html>