<?php
ob_start();
include "../components/connect.php";

$success_msg = $warning_msg = [];

if(isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['pass']);
   
    //check cridentials    
    $select_seller = $conn->prepare("SELECT * FROM sellers WHERE email = ? LIMIT 1");
    $select_seller->execute([$email]);

    if($select_seller->rowCount() > 0) {
        $user = $select_seller->fetch(PDO::FETCH_ASSOC);

        if(password_verify($password, $user['password'])) {
            setcookie('seller_id', $user['id'], time() + 60 * 60 * 24 * 30, '/');
            $success_msg[] = "Login successful! Enjoy the service😊";
        } else 
            $warning_msg[] = "Wrong password! Try again.";
    } else {
        $warning_msg[] = "Incorrect Email or Password!";
    }
                
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ice Cream Delights - Login Page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <?php include "../include/awesome_fonts.php"; ?>
</head>
<body>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="login" autocomplete="off">
            <h2>Login Now</h2>
            <div class="input-field">
                <p>Your Email <span>*</span></p>
                <input type="text" name="email" placeholder="Enter your email..." maxlength="50" required class="box" autocomplete="off">
            </div>
            <div class="input-field">
                <p>Your Password <span>*</span></p>
                <input type="password" name="pass" placeholder="Enter your password..." maxlength="50" required class="box" autocomplete="new-password">
            </div>
                    
            <p class="link">Don't have an account yet? <a href="register.php">register now</a></p>

            <input type="submit" name="submit" value="login now" class="btn">
        </form>
    </div>

    <?php 
        include "../include/sweetalert.php"; 
        require "../components/alert.php";

        // Show alerts
        if(!empty($success_msg)) {
            foreach($success_msg as $msg){
                echo '<script>
                    swal("'.$msg.'", "", "success")
                    .then(() => {
                        window.location.href = "dashboard.php";
                    });
                </script>';
            }
            ob_end_flush();
            exit();
        }
        if(!empty($warning_msg)) {
            foreach($warning_msg as $msg){
                echo '<script>swal("'.$msg.'", "", "warning");</script>';
        }
    }
    ?>
</body>
</html>