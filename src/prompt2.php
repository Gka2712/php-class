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
                    ['role'=>'system','content'=>'あなたはプログラミングの先生です。問題と回答が渡されます。問題と解答から適切にコメントしてください'],
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
    $pdftext=$_POST['pdftext'];
    $answer=$_POST['answer'];
    $prompt='問題'.$pdftext.'回答'.$answer;
    $result=generateText($prompt);
    echo '<textarea name="answer" rows="20" cols="100" readonly>'.$pdftext.'</textarea>';
    echo '<br>'.$result.'<br>';
    echo '<a href="prompt.php">もう一度問題を解く</a><br>';
    echo '<a href="index.php">topに戻る</a>';

?>
    <body>
</html>