<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-17
 * Time: 下午12:14
 */

namespace Jenner\Zebra\Wechat\Client;


use Jenner\Zebra\Wechat\C;

class System extends WechatClient
{
    public function getIpList()
    {
        $uri = $this->uri_prefix . C::get('uri.auth.getcallbackip');
        $result = $this->request_get($uri);

        return $result;
    }
} 