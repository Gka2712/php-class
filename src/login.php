<?php

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>ログイン</title>
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'></link>
        <style>
            body{
                background-color:linen;
            }
        </style>
    </head>
    <body>
        <?php
            session_start();
            if(isset($_SESSION['phpclass_userid'],$_SESSION['phpclass_name'],$_SESSION['phpclass_name'])){
                header('Location:./index.php');
                exit();
            }
            if((array_key_exists('user',$_POST))&&(array_key_exists('password',$_POST))){
                $user=$_POST['user'];
                $password_web=$_POST['password'];
                #データベースの情報
                $hostname_db='mysql';
                $username_db='root';
                $password_db='root_password';
                $dbname_db='phpclass';
                $tablename_db='user';
                $link=mysqli_connect($hostname_db,$username_db,$password_db,$dbname_db);
                $trans=0;#認証有無フラグ
                if(!$link){exit("connect error!");}
                $result=mysqli_query($link,"select * from $tablename_db");
                if(!$result){exit(mysqli_error($link));}
                while($row=mysqli_fetch_assoc($result)){
                    $userID_compare=$row['userId'];
                    $password_compare=hash("sha256",$row['salt'].$password_web);
                    $name_set=$row['name'];
                    if(($password_compare==$row['password'])&&($user==$userID_compare)){
                        mysqli_free_result($result);
                        mysqli_close($link);
                        $trans=1;
                        $_SESSION['phpclass_userid']=$user;
                        $_SESSION['phpclass_password']=$password_web;
                        $_SESSION['phpclass_name']=$name_set;

                        break;
                    }
                }
                if($trans==0){
                    mysqli_free_result($result);
                    mysqli_close($link);
                    echo '<font color="red">ユーザ名またはパスワードが不正です</font>';
                }
                else{
                    header('Location:./index.php');
                    exit();
                }
            }
        ?>
        <h3 class="text-center text-info my-4">学習システム</h3>
        <form method="POST" class="form-group text-center">
            <h4 class="my-4">ユーザID<input type="text" name="user" value="" required="required"></h4>
            <h4 class="my-4">パスワード<input type="password" name="password" value="" required="required"></h4>
            <button type="submit" name="login" value="" class="btn btn-outline-secondary">ログインする</button><br>
            <a href="register.php">新規登録する</a>
        </form>
    </body>
</html>