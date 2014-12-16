<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-16
 * Time: 下午2:53
 */

namespace Jenner\Zebra\Wechat\Client\Card;


use Jenner\Zebra\Wechat\WechatUri;

class Code extends BaseCard
{
    /**
     * 卡券核销部分
     * @param $code
     * @param $card_id
     * @return bool|mixed
     */
    public function consume($code, $card_id)
    {
        $uri = $this->uri_prefix . WechatUri::CARD_CODE_CONSUME;
        return $this->request_post($uri, compact('code', 'card_id'));
    }

    /**
     * code解码接口
     * 通过 choose_card_info 获取的加密字符串
     * @param $encrypt_code
     * @return bool|mixed
     */
    public function decrypt($encrypt_code)
    {
        $uri = $this->uri_prefix . WechatUri::CARD_CODE_DECRYPT;
        return $this->request_post($uri, compact('encrypt_code'));
    }

    /**
     * 查询code
     * @param $code
     * @return bool|mixed
     */
    public function get($code)
    {
        $uri = $this->uri_prefix . WechatUri::CARD_CODE_GET;
        return $this->request_post($uri, compact('code'));
    }

    /**
     * 批量查询卡列表
     * @param $offset
     * @param $count
     * @return bool|mixed
     */
    public function batchGet($offset, $count)
    {
        $uri = $this->uri_prefix . WechatUri::CARD_CODE_BATCH_GET;
        return $this->request_post($uri, compact('offset', 'count'));
    }

    /**
     * 更改code
     * @param $code
     * @param $card_id
     * @param $new_code
     * @return bool|mixed
     */
    public function update($code, $card_id, $new_code)
    {
        $uri = $this->uri_prefix . WechatUri::CARD_CODE_UPDATE;
        return $this->request_post($uri, compact('code', 'card_id', 'new_code'));
    }

    /**
     * 设置卡券失效接口
     * @param $code
     * @param null $card_id
     * @return bool|mixed
     */
    public function unavailable($code, $card_id = null)
    {
        $uri = $this->uri_prefix . WechatUri::CARD_CODE_UNAVAILABLE;
        $params['code'] = $code;
        if (!is_null($card_id)) $params['card_id'] = $card_id;
        return $this->request_post($uri, $params);
    }
} 