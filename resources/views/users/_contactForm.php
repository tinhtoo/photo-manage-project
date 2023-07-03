<?php
    session_start();
    $mode = 'input';
    $errmessage = array();
    if( isset($_POST['back']) && $_POST['back'] ) {
        //
    } else if( isset($_POST['confirm']) && $_POST['confirm']) {
        
        if( !$_POST['name'] ) {
            $errmessage[] = "名前を入力してください";
        } else if( mb_strlen($_POST['name']) > 100 ){
            $errmessage[] = "名前は100文字以内にしてください";
        }
            $_SESSION['name'] = htmlspecialchars($_POST['name'], ENT_QUOTES);
    

        if( !$_POST['email'] ) {
            $errmessage[] = "Eメールを入力してください";
        } else if( mb_strlen($_POST['email']) > 200 ){
              $errmessage[] = "Eメールは200文字以内にしてください";
        } else if( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ){
            $errmessage[] = "メールアドレスが不正です";
        }
            $_SESSION['email'] = htmlspecialchars($_POST['email'], ENT_QUOTES);


        if( !$_POST['subject'] ) {
            $errmessage[] = "件名を入力してください";
        } else if( mb_strlen($_POST['subject']) > 50 ){
            $errmessage[] = "件名は50文字以内にしてください";
        }
            $_SESSION['subject'] = htmlspecialchars($_POST['subject'], ENT_QUOTES);


        if( !$_POST['message'] ){
            $errmessage[] = "お問い合わせ内容を入力してください";
        } else if( mb_strlen($_POST['message']) > 500 ){
            $errmessage[] = "お問い合わせ内容は500文字以内にしてください";
        }
            $_SESSION['message'] = htmlspecialchars($_POST['message'], ENT_QUOTES);
    
        if( $errmessage ){
            $mode = 'input';
        } else {
            $token = bin2hex(random_bytes(32)); 
            $_SESSION['token'] = $token;
            $mode = 'confirm';
        }
    } else if( isset($_POST['send']) && $_POST['send'] ){
        // 送信ボタンを押したとき
        if( !$_POST['token'] || !$_SESSION['token'] || !$_SESSION['email'] ){
            $errmessage[] = '不正な処理が行われました';
            $_SESSION     = array();
            $mode         = 'input';
        } else if( $_POST['token'] != $_SESSION['token'] ){
            $errmessage[] = '不正な処理が行われました';
            $_SESSION     = array();
            $mode         = 'input';
        } else {
            $message  = "お問い合わせを受け付けました \r\n"
                    . "名前: " . $_SESSION['fullname'] . "\r\n"
                    . "email: " . $_SESSION['email'] . "\r\n"
                    . "subject: " . $_SESSION['subject'] . "\r\n"
                    . "お問い合わせ内容:\r\n"
                    . preg_replace("/\r\n|\r|\n/", "\r\n", $_SESSION['message']);
            mail($_SESSION['email'],'お問い合わせありがとうございます',$message);
            mail('admin@black.com','お問い合わせありがとうございます',$message);
            $_SESSION = array();
            $mode = 'send';
        }
    } else {
        $_SESSION['name'] = "";
        $_SESSION['email'] = "";
        $_SESSION['subject'] = "";
        $_SESSION['message'] = "";
    }
?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="utf-8">
    <title>お問い合わせフォーム</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
<?php if( $mode == "input" ){ ?>
    <!-- 入力画面 -->
    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h3 class="mb-5 text-center">お問い合わせ</h3>
                <div class="mb-3">
                <?php
                    if( $errmessage ){
                        echo '<div style="color:red;">';
                        echo implode('<br>', $errmessage );
                        echo '</div>';
                    }   
                ?>
                </div>
                <form action="./contactForm.php" method="post">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="name" placeholder="名前" value="<?php echo $_SESSION["name"] ?>">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="email" placeholder="メールアドレス" value="<?php echo $_SESSION["email"] ?>">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="subject" placeholder="件名" value="<?php echo $_SESSION["subject"] ?>">
                    </div>
                    <div class="mb-4">
                        <textarea class="form-control" name="message" rows="5" placeholder="本文"><?php echo $_SESSION["message"] ?></textarea>
                    </div>
                    <!-- <div class="d-grid">
                        <button type="submit" class="btn btn-success" name="confirm">確認</button>
                    </div> -->
                    <div class="d-grid">
                        <input type="submit" name="confirm" value="確認" class="btn btn-primary btn-lg"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } else if( $mode == "confirm" ){ ?>
    <!-- 確認 -->
    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h3 class="mb-5 text-center">お問い合わせ内容確認</h3>
                <form action="./contactForm.php" method="post">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                    <div class="mb-3">
                        名前：：<?php echo $_SESSION["name"] ?>
                    </div>
                    <div class="mb-3">
                        メールアドレス：：<?php echo $_SESSION["email"] ?>
                    </div>
                    <div class="mb-3">
                        件名：：<?php echo $_SESSION["subject"] ?>
                    </div>
                    <div class="mb-4">
                        本文：：<?php echo nl2br($_SESSION['message']) ?>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success" name="back">戻る</button>
                        <button type="submit" class="btn btn-success" name="send">送信</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } else { ?>
<!-- 完了画面 -->
送信しました。お問い合わせありがとうございました。
<?php } ?>
</body>
</html>