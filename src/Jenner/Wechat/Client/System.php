<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-17
 * Time: 下午12:14
 */

namespace Jenner\Wechat\Client;

use Jenner\Wechat\Config\URI;

class System extends WechatClient
{
    public function getIpList()
    {
        $uri = $this->uri_prefix . URI::AUTH_GET_CALLBACK_IP;
        $result = $this->request_get($uri);

        return $result;
    }
} 