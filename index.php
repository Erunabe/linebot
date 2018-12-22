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

$http_client = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new \LINE\LINEBot($http_client, ['channelSecret' => getenv('CHANNEL_SECRET')]);

$signature=$_SERVER['HTTP'.\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
$events=$bot->parseEventRequest(file_get_contents('php://input'),$signature);

foreach ($events as $event) {
  $bot->replyText($event->getReplyToken(),'TextMessage');
}
// デバッグ
