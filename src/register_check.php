<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>新規登録</title>
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'></link>
        <style>
            body{
                background:linen;
            }
        </style>
    </head>
    <body>
    <h3 class="text-center text-info my-4">学習システム</h3>
        <h3>登録内容の確認</h3>
<?php
    $name=$_POST['name'];
    $user=$_POST['user'];
    $password=$_POST['password'];
    $password_check=$_POST['password_check'];
    if(($password==$password_check)&&
    (strlen($user)>=6)&&
    (strlen($user)<=90)&&
    (strlen($password)>=6)&&
    (strlen($password)<=90)){
        echo '<h4 class="mx-2">名前:'.htmlspecialchars($name).'</h4>';
        echo '<h4 class="mx-2">ユーザーID:'.htmlspecialchars($user).'</h4>';
        echo '<h4 class="mx-2">パスワード:(あなたが設定したパスワード)</h4>';
        echo '<form action="register_completion.php" method="post">';
        echo '<input type="hidden" name="name" value="'.$name.'">';
        echo '<input type="hidden" name="user" value="'.$user.'">';
        echo '<input type="hidden" name="password" value="'.$password.'">';
        echo '<button type="submit" name="btnsubmit" class="btn btn-outline-primary mx-4 my-2">登録する</button>';
        echo '</form>';
        echo '<form action="register.php" method="post">';
        echo '<button type="submit" name="btnregister" class="btn btn-outline-secondary mx-4 my-2">修正する</button>';
        echo '</form>';
    }
    else{
        echo '<h4>エラー</h4>';
        echo '<p>ユーザIDまたはパスワードの入力形式が不正です</p>';
        echo '<form action="register.php" method="post">';
        echo '<button type="submit" name="btnback">戻る</button>';
        echo '</form>';
    }
?>
    </body>
</html>