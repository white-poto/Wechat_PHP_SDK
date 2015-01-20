<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-16
 * Time: 下午12:26
 */

namespace Jenner\Zebra\Wechat\Client\Card;


use Jenner\Zebra\Wechat\WechatConfig;

class Color extends BaseCard
{
    public function get()
    {
        $uri = $this->card_uri_prefix . WechatConfig::CARD_COLOR_GET;
        return $this->request_get($uri);
    }
} 