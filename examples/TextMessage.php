<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-15
 * Time: 下午9:03
 *
 * 主动向微信发送消息
 */


define('WECHAT_APP_ID', 'your app id');
define('WECHAT_SECRET', 'your secret');

$to_user = 'to_user_open_id';
$text = 'hello';
$text_message = new \Jenner\Zebra\Wechat\Client\Message\TextMessage($to_user, $text);
$text_message->send();


/**
 * 或者 你可以这样
 */

\Jenner\Zebra\Wechat\Client\WechatClient::registerAuthInfo('your app_id', 'your secret');
$to_user = 'to_user_open_id';
$text = 'hello';
$text_message = new \Jenner\Zebra\Wechat\Client\Message\TextMessage($to_user, $text);
$text_message->send();