<?php

require_once __DIR__ . '/vendor/autoload.php';

/*
* 各キーを環境変数に設定
*
* Line Developers
* CHANNEL_SECRET = Channel Secret
* CHANNEL_ACCESS_TOKEN = Channel Access Token
*
*/

// Line Message APIに接続
$input = file_get_contents('php://input');
$json = json_decode($input);
$event = $json--->events[0];
$http_client = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new \LINE\LINEBot($http_client, ['channelSecret' => getenv('CHANNEL_SECRET')]);

// メッセージ識別子を取得
$event_type = $event->type;
$event_message_type = $event->message->type;

// メッセージの場合
if ('message' == $event_type) {

    // テキストメッセージの場合
    if ('text' == $event_message_type) {

        // メッセージ取得
        $text = $event->message->text;

        // メッセージを受け取ったらメッセージをそのまま返す
        $text_message_builder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
        $response = $bot->replyMessage($event->replyToken, $text_message_builder);
    }
}

// デバッグ
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
