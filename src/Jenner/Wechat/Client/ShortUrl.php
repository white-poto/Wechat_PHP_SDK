<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-14
 * Time: 下午12:01
 */

namespace Jenner\Wechat\Client;

use Jenner\Wechat\WechatConfig;

class ShortUrl extends WechatClient
{
    /**
     * 长连接转短连接
     * @param $long_url
     * @return bool|mixed
     */
    public function get($long_url)
    {
        $uri = $this->uri_prefix . WechatConfig::SHORT_URL;
        $param = [
            'action' => 'long2short',
            'long_url' => $long_url,
        ];
        return $this->request_post($uri, $param);
    }
} 