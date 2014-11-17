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

use Jenner\Zebra\Wechat\Client\Validator;

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

    public function checkWechatServerId(){
        $wechat_ip = self::getIp();
        $validator = new Validator();

        $result = $validator->getIpList();
        if(isset($result['errcode'])){
            throw new \Exception(json_encode($result));
        }

        $ip_list = $result['ip_list'];
        if(in_array($wechat_ip, $ip_list)){
            return true;
        }
        return false;
    }

    /**
     * 获取客户端真实IP
     *
     * @param int $type
     * @return string
     */
    protected function getIp($type = 0)
    {
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) $cip = $_SERVER["HTTP_CLIENT_IP"];
        else if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        else if (!empty($_SERVER["REMOTE_ADDR"])) $cip = $_SERVER["REMOTE_ADDR"];
        else $cip = "";
        \preg_match("/[\d\.]{7,15}/", $cip, $cips);
        $cip = $cips[0] ? $cips[0] : 'unknown';
        unset($cips);
        if ($type == 1) $cip = \myip2long($cip);
        return $cip;
    }

} 