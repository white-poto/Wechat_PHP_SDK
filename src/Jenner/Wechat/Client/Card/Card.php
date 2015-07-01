<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-16
 * Time: 下午12:19
 */

namespace Jenner\Wechat\Client\Card;

use Jenner\Wechat\Config\URI;

class Card extends AbstractCard
{
    /**
     * 创建卡券
     * @param $card
     * @return bool|mixed
     */
    public function create($card)
    {
        $uri = $this->card_uri_prefix . URI::CARD_CREATE;
        return $this->request_post($uri, $card);
    }


    /**
     * 查询卡券详情
     * @param $card_id
     * @return bool|mixed
     */
    public function get($card_id)
    {
        $uri = $this->card_uri_prefix . URI::CARD_GET;
        return $this->request_post($uri, compact('card_id'));
    }

    public function update($card)
    {
        $uri = $this->card_uri_prefix . URI::CARD_UPDATE;
        return $this->request_post($uri, $card);
    }

    public function batchGet($offset = 0, $count = 50)
    {
        $uri = $this->card_uri_prefix . URI::CARD_BATCH_GET;
        return $this->request_post($uri, compact('offset', 'count'));
    }
} 