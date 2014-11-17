<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-17
 * Time: 下午12:14
 */

namespace Jenner\Zebra\Wechat\Client;


class Validator extends WechatClient
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getIpList()
    {
        $uri = $this->uri_prefix . $this->uri_config['auth']['getcallbackip'];
        $result = $this->request_get($uri);
        
        return $result;
    }
} 