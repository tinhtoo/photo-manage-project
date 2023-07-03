<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'php_mailer/vendor/autoload.php';

$mail = new PHPMailer(true);

    session_start();
    $mode = 'input';
    $errmessage = array();

    if( isset($_POST['back']) && $_POST['back'] ) {
        //
    } else if( isset($_POST['confirm']) && $_POST['confirm']) {
        
        if( !$_POST['name'] ) {
            $errmessage[] = "名前を入力してください";
        } else if( mb_strlen($_POST['name']) > 50 ){
            $errmessage[] = "名前は100文字以内にしてください";
        }
            $_SESSION['name'] = htmlspecialchars($_POST['name'], ENT_QUOTES);
    

        if( !$_POST['email'] ) {
            $errmessage[] = "Eメールを入力してください";
        } else if( mb_strlen($_POST['email']) > 50 ){
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
            try{
                //server
                $mail->SMTPDebug = 0; //本番では0とかにする。
                $mail->isSMTP();
                $mail->Host = 'smtp.mailtrap.io';
                $mail->SMTPAuth = true;
                $mail->Username = '6bcaeb786bf167'; //ここにusername入れる
                $mail->Password = 'beed9a19640e98'; //ここにpassword入れる
                $mail->SMTPSecure = 'tls';
                $mail->Port = 2525;    
        
                //Recipients
                $mail->setFrom($_SESSION['email'], $_SESSION['name']); //アドレスだけでも動きます
                $mail->addAddress('admin@example.com', 'Mr Admin');
        
                //Content
                $message  = "以下の通りにお問い合わせ内容を受け付けました。\r\n"
                            . "名前: " . $_SESSION['name'] . "\r\n"
                            . "email: " . $_SESSION['email'] . "\r\n"
                            . "subject: " . $_SESSION['subject'] . "\r\n"
                            . "お問い合わせ内容:\r\n"
                            . preg_replace("/\r\n|\r|\n/", "\r\n", $_SESSION['message']);
                $mail->CharSet = 'UTF-8'; //文字化け防止
                $mail->Subject = $_SESSION['subject'];
                $mail->Body    = $_SESSION['name']."さん、"."からお問い合わせメールが届きました。". "\r\n" . $message;
        
                //adminからuserへ送信
                $mail->send();

                //Recipients
                $mail->setFrom('admin@example.com', 'admin');
                $mail->ClearAddresses();
                $mail->addAddress($_SESSION['email'], $_SESSION['name']); //アドレスだけでも動きます
        
                //Content
                $message  = "以下の通りにお問い合わせ内容を受け付けました。\r\n"
                            . "名前: " . $_SESSION['name'] . "\r\n"
                            . "email: " . $_SESSION['email'] . "\r\n"
                            . "subject: " . $_SESSION['subject'] . "\r\n"
                            . "お問い合わせ内容:\r\n"
                            . preg_replace("/\r\n|\r|\n/", "\r\n", $_SESSION['message']);
                $mail->CharSet = 'UTF-8'; //文字化け防止
                $mail->Subject = $_SESSION['subject'];
                $mail->Body    = $_SESSION['name']."さん、"."お問い合わせありがとうございます。" . "\r\n" . $message;
        
                // userからadminへ送信
                $mail->send();                
        
                $mode = 'send';
        
            }catch(Exception $e){
                echo "error:".$mail->ErrorInfo;
            }
            // $mode = 'send';
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" 
    integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ"
    crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $('#contact').validate({
                rules: {
                    name:{
                        required: true,
                        maxlength: 50,
                    },
                    email:{
                        required: true,
                        maxlength: 50,
                    },
                    subject:{
                        required: true,
                        maxlength: 50,
                    },
                    message:{
                        required: true,
                        maxlength: 500,
                    },
                },
                messages:{
                    name:{
                        required: '名前を入力してください。',
                        maxlength: '名前は50字以内でご入力ください。'
                    },
                    email:{
                        required: 'メールアドレスを入力してください。',
                        maxlength: 'メールアドレスは50字以内でご入力ください。'
                    },
                    subject:{
                        required: '件名を入力してください。',
                        maxlength: '件名は50字以内でご入力ください。'
                    },
                    message:{
                        required: 'お問い合わせ内容を入力してください。',
                        maxlength: 'お問い合わせ内容は500字以内でご入力ください。'
                    },
                    errorPlacement: function(error, element){
                        var errorKey = $(element).attr('id') + 'Error';
                        $('#error_' + errorKey).remove();
                        element.addClass('is-invalid');
                        const errorP = $('<p>').text(error[0].innerText);
                        const errorDiv = $('<div class="invalid-feedback" id="error_' + errorKey + '">').append(errorP);
                        element.parent().append(errorDiv);
                    },
                    success: function(error, element) {
                        var errorKey = $(element).attr('id') + 'Error';
                        $('#error_' + errorKey).remove();
                        $(error).remove();
                        $(element).removeClass('is-invalid');
                        $(element).removeClass('error');
                        },
                 }  
            });
        });
</script>
<style type="text/css">
    label.error {
    color: red;
    }
</style>
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
                            echo '<div class="alert alert-danger" role="alert">';
                            echo implode('<br>', $errmessage );
                            echo '</div>';
                        }   
                    ?>
                </div>
                <form id="contact" action="./contactForm.php" method="post">
                    <div class="mb-3">
                        <input type="text" class="form-control required" name="name" placeholder="名前" value="<?php echo $_SESSION["name"] ?>">
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
                <h3 class="mb-5 text-center">お問い合わせ内容の確認</h3>
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
                    <div class="btn">
                        <input type="submit" name="back" value="戻る" class="btn btn-info btn-lg"/>
                        <input type="submit" name="send" value="送信" class="btn btn-primary btn-lg"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } else { ?>
<!-- 完了画面 -->
<?php 

    require_once('./db.php');
    ConnectDb();
    
?>
<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h3 class="mb-5 text-center">お問い合わせ内容を送信しました。</h3>
            <h4 class="mb-5 text-center">ありがとうございました。</h4>
        </div>
        <div class="mb-5 text-center"><a href="/">トップ画面へ</a></div>
    </div>
</div>
<?php } ?>
</body>
</html>