<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

function generateText($prompt) {
    $client=new Client();
    $response=$client->post('https://api.openai.com/v1/chat/completions',[
        'headers'=>[
            'Authorization'=>'Bearer api_key',
            'Content-Type'=>'application/json',
        ],
        'json'=>[
            'model'=>'gpt-3.5-turbo',
            'messages'=>[
                ['role'=>'system','content'=>'You are a helpful assistant.'],
                ['role'=>'user','content'=>$prompt]
            ]
        ]
    ]);
    $responsedata=json_decode($response->getBody(),true);
    $answer=$responsedata['choices'][0]['message']['content'];
    return $answer;
}

// 使用例
$prompt = "What is the capital of France?";
$result = generateText($prompt);
echo $result
?>
