<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-14
 * Time: 下午12:01
 */

namespace Jenner\Wechat\Client;

use Jenner\Wechat\Config\URI;

class ShortUrl extends Client
{
    const API_URL = 'https://api.weixin.qq.com/cgi-bin/shorturl';

    /**
     * 长连接转短连接
     * @param $long_url
     * @return bool|mixed
     */
    public function get($long_url)
    {
        $param = [
            'action' => 'long2short',
            'long_url' => $long_url,
        ];
        return $this->request_post(self::API_URL, $param);
    }
} 