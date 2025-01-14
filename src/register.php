<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>新規登録</title>
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'></link>
        <style>
            body{
                background-color:linen;
            }
        </style>
    </head>
    <body>
        <h3 class="text-center text-info my-4">学習システム</h3>
        <form method="POST" action="register_check.php" class="form-group">
            <h4 class="py-2">名前<input type="text" name="name" value="" required="required"><br></h4>
            <h4 class="py-2">ユーザID<input type="text" name="user" pattern="[A-Za-z0-9]*" required="required"></h4>
            <h6 class="py-2 px-2">*ユーザIDは半角英数字のみ使うことができます。<br>
            またユーザIDは、6文字以上90文字以下でお願いします。<br></h6>
            <h4 class="py-2">パスワード<input type="password" name="password" required="required"></h4>
            <h4 class="py-2">パスワード確認<input type="password" name="password_check" required="required"></h4>
            <button type="submit" name="register" value="" class='btn btn-outline-primary mx-4'>登録</button><br>
            <button type="reset" name="reset" value="" class='btn btn-outline-secondary mx-4 my-2'>リセット</button>
            <br>
        </form>
        <form method="post" action="login.php">
            <button type="submit" name="btnback" class='btn btn-outline-primary mx-4'>戻る</button>
        </form>
    </body>
</html>