<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-15
 * Time: 下午9:08
 */
use \Jenner\Zebra\Wechat\WechatServer;
use \Jenner\Zebra\Wechat\Response\TextResponse;

$token = 'you wechat token';
$server = new WechatServer($token);

//处理事件前调用，无论是否有注册事件处理器
$server->on('before', function(WechatServer $server, $request){
    //do something
});

//处理事件后调用，$result为事件处理器的返回值
$server->on('after', function(WechatServer $server, $result){
    //do something
});

//未知消息处理器
$server->on('unknown_message', function(WechatServer $server, $request){
    //do something
});

//未知时间处理器
$server->on('unknown_event', function(WechatServer $server, $request){
    //do something
});

//处理微信文本消息推送
$server->on('text', function(WechatServer $server, $request){
    $to_user = $server->getFromUserName();
    $from_user = $server->getToUserName();
    $response = new TextResponse($to_user, $from_user, 'hello');
    $server->send($response);
    $result = 'success';

    //如果你定义了after的回调，这个返回值将作为参数传递给after函数
    return $result;
});


//处理微信关注推送
$server->on('subscribe', function(WechatServer $server, $request){
    $to_user = $server->getFromUserName();
    $from_user = $server->getToUserName();
    $response = new TextResponse($to_user, $from_user, 'thx');
    $server->send($response);
});



