<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-16
 * Time: 下午3:09
 */

namespace Jenner\Wechat\Client\Card;


use Jenner\Wechat\Config\URI;

class WhiteList extends AbstractCard
{
    /**
     * 设置测试用户白名单
     * @param $list
     * @return bool|mixed
     */
    public function set($list)
    {
        $uri = $this->card_uri_prefix . URI::CARD_TEST_WHITE_LIST;
        return $this->request_post($uri, $list);
    }
} 