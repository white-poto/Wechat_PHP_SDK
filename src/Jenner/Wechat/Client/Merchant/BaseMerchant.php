<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-15
 * Time: 上午10:15
 */

namespace Jenner\Zebra\Wechat\Client\Merchant;


use Jenner\Zebra\Wechat\Client\WechatClient;
use Jenner\Zebra\Wechat\WechatConfig;

class BaseMerchant extends WechatClient
{
    protected $merchant_uri_prefix;

    public function __construct()
    {
        parent::__construct();
        $this->merchant_uri_prefix = WechatConfig::MERCHANT_PREFIX;
    }
} 