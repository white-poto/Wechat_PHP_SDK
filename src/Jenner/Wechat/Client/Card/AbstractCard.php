<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-16
 * Time: 下午12:13
 */

namespace Jenner\Wechat\Client\Card;


use Jenner\Wechat\Client\WechatClient;
use Jenner\Wechat\WechatConfig;

abstract class AbstractCard extends WechatClient
{
    public function __construct()
    {
        parent::__construct();
        $this->card_uri_prefix = WechatConfig::CARD_PREFIX;
    }
} 