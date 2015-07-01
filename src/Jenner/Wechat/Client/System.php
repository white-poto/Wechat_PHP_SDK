<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-17
 * Time: 下午12:14
 */

namespace Jenner\Wechat\Client;

use Jenner\Wechat\Config\URI;

class System extends Client
{

    const API_CALLBACK_IP = 'https://api.weixin.qq.com/cgi-bin/getcallbackip';

    public function getIpList()
    {
        $result = $this->request_get(self::API_CALLBACK_IP);

        return $result;
    }
} 