<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-16
 * Time: 下午3:19
 */

namespace Jenner\Wechat\Client\Card;


use Jenner\Wechat\WechatConfig;

class MovieTicket extends AbstractCard
{
    /**
     * 领取电影票后通过调用“更新电影票”接口 update 电影信息及用户选座信息。
     * @param $card
     * @return bool|mixed
     */
    public function updateUser($card)
    {
        $uri = $this->card_uri_prefix . WechatConfig::CARD_MOVIE_TICKET;
        return $this->request_post($uri, $card);
    }
} 