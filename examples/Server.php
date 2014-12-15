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


