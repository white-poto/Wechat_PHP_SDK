<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-16
 * Time: 下午12:22
 */

namespace Jenner\Wechat\Client\Card;


use Jenner\Wechat\WechatConfig;

class Location extends AbstractCard
{
    public function batchAdd($location)
    {
        $uri = $this->card_uri_prefix . WechatConfig::CARD_LOCATION_BATCH_ADD;
        return $this->request_post($uri, $location);
    }

    public function batchGet($offset, $count)
    {
        $uri = $this->card_uri_prefix . WechatConfig::CARD_LOCATION_BATCH_GET;
        return $this->request_post($uri, compact('offset', 'count'));
    }
} 