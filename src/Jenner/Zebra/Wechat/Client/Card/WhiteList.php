<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-16
 * Time: 下午3:09
 */

namespace Jenner\Zebra\Wechat\Client\Card;


use Jenner\Zebra\Wechat\WechatUri;

class WhiteList extends BaseCard
{
    /**
     * 设置测试用户白名单
     * @param $list
     * @return bool|mixed
     */
    public function set($list)
    {
        $uri = $this->uri_prefix . WechatUri::CARD_TEST_WHITE_LIST;
        return $this->request_post($uri, $list);
    }
} 