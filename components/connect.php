<?php
    $server = "mysql: host=localhost; dbname=icecream_db";
    $db_user = "root";
    $db_password = "123456789";

    $conn = new PDO($server, $db_user, $db_password);

    if(!$conn) {
        echo 'not connected';
    }

    function unique_id() {
        $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ";
        $charLength = strlen($chars);
        $randomString = '';
        for($i = 0; $i < 20;$i++) {
            $randomString .=$chars[mt_rand(0, $charLength -1)];
        }
        return $randomString;
    }
?>