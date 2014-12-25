<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-16
 * Time: 下午12:19
 */

namespace Jenner\Zebra\Wechat\Client\Card;

use Jenner\Zebra\Wechat\WechatUri;

class Card extends BaseCard
{
    /**
     * 创建卡券
     * @param $card
     * @return bool|mixed
     */
    public function create($card)
    {
        $uri = $this->uri_prefix . WechatUri::CARD_CREATE;
        return $this->request_post($uri, $card);
    }


    /**
     * 查询卡券详情
     * @param $card_id
     * @return bool|mixed
     */
    public function get($card_id){
        $uri = $this->uri_prefix . WechatUri::CARD_GET;
        return $this->request_post($uri, compact('card_id'));
    }

    public function update($card){
        $uri = $this->uri_prefix . WechatUri::CARD_UPDATE;
        return $this->request_post($uri, $card);
    }
} 