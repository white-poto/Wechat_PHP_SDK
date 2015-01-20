<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-16
 * Time: 下午3:22
 */

namespace Jenner\Zebra\Wechat\Client\Card;


use Jenner\Zebra\Wechat\WechatConfig;

class BoardingPass extends BaseCard
{
    /**
     * 在线选座
     * @param $card
     * @return bool|mixed
     */
    public function checkIn($card)
    {
        $uri = $this->card_uri_prefix . WechatConfig::CARD_BOARDING_PASS_CHECK_IN;
        return $this->request_post($uri, $card);
    }
} 