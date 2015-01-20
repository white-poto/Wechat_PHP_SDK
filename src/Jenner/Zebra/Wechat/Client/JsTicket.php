<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 15-1-13
 * Time: 下午9:05
 */

namespace Jenner\Zebra\Wechat\Client;


use Jenner\Zebra\Wechat\WechatConfig;

class JsTicket extends WechatClient
{

    public function getSignPackage($js_api_ticket = null)
    {
        if (is_null($js_api_ticket)) {
            $js_api_ticket = $this->getJsApiTicket()['ticket'];
        }
        $url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $timestamp = time();
        $nonce_str = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升faf序排序
        $string = "jsapi_ticket={$js_api_ticket}&noncestr={$nonce_str}&timestamp={$timestamp}&url={$url}";

        $signature = sha1($string);

        $signPackage = array(
            "appId" => WECHAT_APP_ID,
            "nonceStr" => $nonce_str,
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
            "rawString" => $string,
            'jsapi_ticket' => $js_api_ticket,
        );
        return $signPackage;
    }

    private function createNonceStr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    public function getCardTicket()
    {
        return $this->getTicket('wx_card');
    }

    public function getJsApiTicket()
    {
        return $this->getTicket('jsapi');
    }

    public function getTicket($type)
    {
        $params = ['type' => $type];
        $uri = $this->uri_prefix . WechatConfig::TICKET_GET_TICKET;
        return $this->request_get($uri, $params);
    }
} 