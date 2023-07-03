<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="utf-8">
    <title>お問い合わせフォーム確認</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>
<body>
<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h3 class="mb-5 text-center">お問い合わせ</h3>
            <form method="post">
                <div class="mb-3">
                    <input type="text" class="form-control" name="name" placeholder="名前" value="">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="email" placeholder="メールアドレス" value="">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="subject" placeholder="件名" value="">
                </div>
                <div class="mb-4">
                    <textarea class="form-control" name="message" rows="5" placeholder="本文"></textarea>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-success">送信</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>