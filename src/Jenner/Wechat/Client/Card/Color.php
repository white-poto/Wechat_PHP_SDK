<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-16
 * Time: 下午12:26
 */

namespace Jenner\Wechat\Client\Card;


use Jenner\Wechat\Config\URI;

class Color extends AbstractCard
{
    public function get()
    {
        $uri = $this->card_uri_prefix . URI::CARD_COLOR_GET;
        return $this->request_get($uri);
    }
} 