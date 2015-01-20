<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-16
 * Time: 下午3:13
 */

namespace Jenner\Zebra\Wechat\Client\Card;


use Jenner\Zebra\Wechat\WechatConfig;

class MemberCard extends BaseCard
{
    /**
     * 激活/绑定会员卡
     * @param $card
     * @return bool|mixed
     */
    public function activate($card)
    {
        $uri = $this->card_uri_prefix . WechatConfig::CARD_MEMBER_ACTIVATE;
        return $this->request_post($uri, $card);
    }

    /**
     * 会员卡交易 会员卡交易后每次积分及余额变更需通过接口通知微信，便于后续消息通知及其他扩展功能。
     * @param $member_card
     * @return bool|mixed
     */
    public function updateUser($member_card){
        $uri = $this->card_uri_prefix . WechatConfig::CARD_MEMBER_UPDATE;
        return $this->request_post($uri, $member_card);
    }
} 