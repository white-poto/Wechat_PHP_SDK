<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-17
 * Time: 下午12:14
 */

namespace Jenner\Zebra\Wechat\Client;


use Jenner\Zebra\Wechat\C;
use Jenner\Zebra\Wechat\WechatUri;

class System extends WechatClient
{
    public function getIpList()
    {
        $uri = $this->uri_prefix . WechatUri::AUTH_GET_CALLBACK_IP;
        $result = $this->request_get($uri);

        return $result;
    }
} 