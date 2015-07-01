<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-16
 * Time: 下午3:22
 */

namespace Jenner\Wechat\Client\Card;


use Jenner\Wechat\Config\URI;

class BoardingPass extends AbstractCard
{
    /**
     * 在线选座
     * @param $card
     * @return bool|mixed
     */
    public function checkIn($card)
    {
        $uri = $this->card_uri_prefix . URI::CARD_BOARDING_PASS_CHECK_IN;
        return $this->request_post($uri, $card);
    }
} 