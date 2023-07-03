<?php
function ConnectDb()
{
    try {
    $link = new mysqli('mysql', 'root', '', 'laravel');
        if (!$link) {
            die('接続できませんでした: ' . mysql_error());
        }

        $name     = $_SESSION['name'];
        $email    = $_SESSION['email'];
        $subject  = $_SESSION['subject'];
        $message  = $_SESSION['message'];

        $sql = "INSERT INTO contacts (name, email, subject, message) VALUES ('" . $name . "', '" . $email . "', '" . $subject . "', '" . $message . "')";

        
        $result_flag = $link->query($sql);

        $link->close();
    
    } catch (PDOException $e) {
        // エラー発生
        echo $e->getMessage();
     
    } finally {
        // DB接続を閉じる
        $link->close();
    }
}
?>