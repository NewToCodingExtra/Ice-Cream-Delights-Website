<?php
    include "../include/init_cookie.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ice Cream Delights - Admin Messages</title>
    <?php include "../include/include_styling.php"; ?>
</head>
<body>
    
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="message-container">
            <div class="heading">
                <h1>Unread Messages</h1>
                <img src="../image/separator-img.png">
            </div>
            <div class="box-container">
                <?php 
                    $select_message = $conn->prepare("SELECT * FROM message");
                    $select_message->execute();

                    if($select_message->rowCount() > 0) {
                        while($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <div class="box">
                        <h3 class="name"><?= $fetch_message['name']; ?></h3>
                        <h4><?= $fetch_message['subject']; ?></h4>
                        <p><?= $fetch_message['message']; ?></p>
                        <form action="" method="post">
                            <input type="hidden" name="delete_id" value="<?= $fetch_message['id']; ?>">
                            <input type="submit" name="delete_msg" value="Delete Message" class="btn" onclick="return confirm('Delete this message?')">
                        </form>
                    </div>
                    <?php
                        }
                    }else{
                        echo "<div class='empty'>
                                <p>No unread message yet!</p>
                            </div>";
                    }
                ?>
            </div>
        </section>
    </div>

    <?php include "../include/include_script.php"; ?>
</body>
</html>