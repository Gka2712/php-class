<html>
    <head>
        <meta charset="UTF-8" />
        <title>新規登録完了</title>
    </head>
    <body>
<?php 
    #webシステム利用者の情報
    $name=$_POST['name'];
    $user=$_POST['user'];
    $password_web=$_POST['password'];
    #データベースの情報
    $hostname_db='mysql';
    $username_db='root';
    $password_db='root_password';
    $dbname_db='phpclass';
    $tablename_db='user';
    $tablename2_db='manage';

    mysqli_report(MYSQLI_REPORT_ERROR|MYSQLI_REPORT_STRICT);
    $link=mysqli_connect($hostname_db,$username_db,$password_db,$dbname_db);
    if(!$link){exit("障害が起きました。しばらくお待ちください");}
    $salt=bin2hex(random_bytes(16));
    $password_web=$salt.$password_web;
    $password_web=hash("sha256",$password_web);
    $result=mysqli_query($link,"INSERT INTO $tablename_db SET name='$name',userId='$user',password='$password_web',salt='$salt'");
    if(!$result){
        $error=mysqli_error($link);
        exit($error);
    }
    $result2=mysqli_query($link,"INSERT INTO $tablename2_db SET userId='$user',viewnum=0");
    if(!$result2){
        $error=mysqli_error($link);
        exit($error);
    }
    mysqli_close($link);
    echo <<<EOT
    <p>登録を完了しました</p>
    <form action="login.php" method="post">
        <button type="submit" name="btnback" value="">ログイン画面</button>
    </form>
EOT;

?>
    </body>
</html>