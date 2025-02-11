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
        <div class="text-center">
            <button class="btn btn-outline-primary" onclick="location.href='index.php'">問題を解く</button>
        </div>
<?php
    $hostname_db='mysql';
    $username_db='root';
    $password_db='root_password';
    $dbname_db='phpclass';
    $tablename_db='manage';

    require 'vendor/autoload.php';

    use GuzzleHttp\Client;
    use Spatie\PdfToText\Pdf;
    function generateText($prompt) {
        $client=new Client();
        $response=$client->post('https://api.openai.com/v1/chat/completions',[
            'headers'=>[
                'Authorization'=>'Bearer my-openai-key',
                'Content-Type'=>'application/json',
            ],
            'json'=>[
                'model'=>'gpt-3.5-turbo',
                'messages'=>[
                    ['role'=>'system','content'=>'あなたはプログラミングの先生です。プロンプトに復習した内容が乗っています。あなたは復習問題を一つ出してください'],
                    ['role'=>'user','content'=>$prompt]
                ]
            ]
        ]);
        $responsedata=json_decode($response->getBody(),true);
        $answer=$responsedata['choices'][0]['message']['content'];
        return $answer;
    }
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
    mysqli_report(MYSQLI_REPORT_OFF);
    $link=mysqli_connect($hostname_db,$username_db,$password_db,$dbname_db);
    if(!$link){exit("障害が起きました。しばらくお待ちください");}
    $result=mysqli_query($link,"select * from $tablename_db where userId='$suserId'");
    if(!$result){exit(mysqli_error($link));}
    $row=mysqli_fetch_assoc($result);
    $viewnum=$row['viewnum'];
    mysqli_free_result($result);
    mysqli_close($link);
    $pdftext='以下がpdfの内容です。';
    for($i=1;$i<=$viewnum;$i++){
        $pdffile='pdf/class'.$i.'.pdf';
        $pdftext=$i.'回目の講義'.$pdftext.Pdf::getText($pdffile);
    }
    #echo $pdftext;
    $result=generateText($pdftext);
    echo '<br>'.$result.'<br>';
    echo '<form method="post" action="prompt2.php">';
    echo '<textarea name="answer" rows="20" cols="100"></textarea>';
    echo '<input type="hidden" name="pdftext" value="'.htmlspecialchars($pdftext).'"><br>';
    echo '<button type="submit" name="comment" class="btn btn-outline-primary">提出</button>';
    echo '</form>';
?>
    <body>
</html>