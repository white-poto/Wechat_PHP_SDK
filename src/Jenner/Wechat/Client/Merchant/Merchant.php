<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-15
 * Time: 上午10:15
 */

namespace Jenner\Wechat\Client\Merchant;


use Jenner\Wechat\Client\WechatClient;
use Jenner\Wechat\WechatConfig;

class Merchant extends WechatClient
{
    public function __construct()
    {
        parent::__construct();
        $this->uri_prefix = WechatConfig::MERCHANT_PREFIX;
    }
} 