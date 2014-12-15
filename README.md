Zebra-Wechat
===================
微信SDK
目前处于开发状态，目前实现了以下功能：
 * 接收微信服务器推送信息，对推送信息类型进行识别
 * 微信API客户端封装（用户管理、用户组管理、客服管理、自定义菜单管理、系统管理等）
 * 微信跳转验证封装

[博客地址:www.huyanping.cn](http://www.huyanping.cn/ "程序猿始终不够")

**接收微信推送示例**
```php
use \Jenner\Zebra\Wechat\WechatServer;
use \Jenner\Zebra\Wechat\Response\TextResponse;

$token = 'you wechat token';
$server = new WechatServer($token);
$server->on('before', function(WechatServer $server, $request){
    //do something
});
$server->on('after', function(WechatServer $server, $result){
    //do something
});
$server->on('unknown_message', function(WechatServer $server, $request){
    //do something
});
$server->on('unknown_event', function(WechatServer $server, $request){
    //do something
});
$server->on('text', function(WechatServer $server, $request){
    $to_user = $server->getFromUserName();
    $from_user = $server->getToUserName();
    $response = new TextResponse($to_user, $from_user, 'hello');
    $server->send($response);
});
```


**主动向微信发送消息**
```php
define('WECHAT_APP_ID', 'your app id');
define('WECHAT_SECRET', 'your secret');

$to_user = 'to_user_open_id';
$text = 'hello';
$text_message = new \Jenner\Zebra\Wechat\Client\Message\TextMessage($to_user, $text);
$text_message->send();
```