<?php
    $hostname_db='mysql';
    $username_db='root';
    $password_db='root_password';
    $dbname_db='phpclass';
    $tablename_db='manage';

    session_start();
    if(array_key_exists('logout',$_POST)){
        session_unset();
        session_destroy();
    }
    
    if(!isset($_SESSION['phpclass_userid'],$_SESSION['phpclass_password'],$_SESSION['phpclass_name'])){
        header('Location:./login.php');
        exit();
    }
    $suserId=$_SESSION['phpclass_userid'];
    if(array_key_exists('pdfview',$_POST)){
        echo "hello pdfview";
        mysqli_report(MYSQLI_REPORT_OFF);
        $link=mysqli_connect($hostname_db,$username_db,$password_db,$dbname_db);
        if(!$link){exit("障害が起きました。しばらくお待ちください");}
        $result=mysqli_query($link,"SELECT * FROM $tablename_db WHERE userId='$suserId'");
        if(!$result){exit(mysqli_error($link));}
        $row=mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        $viewnum=$row['viewnum'];
        $result=mysqli_query($link,"UPDATE $tablename_db SET viewnum=$viewnum+1 WHERE userId='$suserId'");
        if(!$result){exit(mysqli_error($link));}
        mysqli_close($link);
        header('Location:./pdf/class'.$viewnum.'.pdf');
        exit();
    }
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>class</title>
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'></link>
        <style>
            body{
                background-color:linen;
            }
        </style>
    </head>
    <body>
        <form method="POST" class="text-right">
            <button type="submit" name="logout" class="btn btn-outline-secondary">ログアウト</button>
        </form>
        <?php       
            mysqli_report(MYSQLI_REPORT_OFF);
            $link=mysqli_connect($hostname_db,$username_db,$password_db,$dbname_db);
            if(!$link){exit("障害が起きました。しばらくお待ちください");}
            $result=mysqli_query($link,"select * from $tablename_db where userId='$suserId'");
            if(!$result){exit(mysqli_error($link));}
            $row=mysqli_fetch_assoc($result);
            $viewnum=$row['viewnum'];
            mysqli_free_result($result);
            mysqli_close($link);

            
        ?>
        <h3 class="text-center text-info my-4">学習システム</h3>
        <div class="text-center">
            <button class="btn btn-outline-primary" onclick="location.href='prompt.php'">問題を解く</button>
        </div>
        <h3 class="my-3">講義スライド</h3>
        本講義は13回分あります。順番に受講してください。
        <ul class="list-group my-4">
        <?php

            for($i=1;$i<=13;$i++)
            {
                echo "<p>".$i."回目</p>";
                if($viewnum+1>$i){
                    echo "<li><form method='POST' action='pdf/class$i.pdf'><button type='submit' value='$i' class='btn btn-outline-primary mx-4'>".$i."回目の資料</button></form></li>";                   
                }
                else if($viewnum+1==$i){
                    echo "<li><form method='POST'><button type='submit' name='pdfview' value='$i' class='btn btn-outline-primary mx-4'>".$i."回目の資料</button></form></li>";
                }
                else{
                    echo "<li><form method='POST'><button type='submit' name='pdfview' value='$i' disabled=True class='btn btn-outline-primary mx-4'>".$i."回目資料</button>まだ閲覧することができません。</form></li>";
                }
                #echo "<li><a href='pdf/class.$i.pdf'>pdf$i</a></li>";
            }
        ?>
        </ul>
        <form method="POST">
            <button type="submit" name="logout" class="btn btn-outline-secondary">ログアウト</button>
        </form>
        
    </body>
</html>