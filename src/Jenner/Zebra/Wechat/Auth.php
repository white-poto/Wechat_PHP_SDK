<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-13
 * Time: 上午11:08
 *
 * 微信请求及响应验证工具类
 */

namespace Jenner\Zebra\Wechat;

use Jenner\Zebra\Wechat\Client\System;
use Jenner\Zebra\Tools\Server;

class Auth {

    /**
     * 验证消息真实性
     *
     * @param  string $token 验证信息
     * @return boolean
     */
    public static function validateSignature($token) {
        if ( ! (isset($_GET['signature']) && isset($_GET['timestamp']) && isset($_GET['nonce']))) {
            return FALSE;
        }

        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        $signatureArray = [$token, $timestamp, $nonce];
        sort($signatureArray,SORT_STRING);
        return sha1(implode($signatureArray)) == $signature;
    }

    /**
     * 修改微信API配置时，微信会发送验证到URL
     * 判断此次请求是否为验证请求
     * 如果是，你需要在上层直接输出原始的echostr并返回
     *
     * @return boolean
     */
    public static function isValid() {
        return isset($_GET['echostr']);
    }


    /**
     * 检查微信推送时，IP是否正确
     * @return bool
     * @throws \Exception
     */
    public static function checkWechatServerId(){
        $wechat_ip = Server::getIp();
        $system = new System();

        $result = $system->getIpList();
        if($system->isError()) return false;

        $ip_list = $result['ip_list'];
        if(in_array($wechat_ip, $ip_list)){
            return true;
        }
        return false;
    }
} 