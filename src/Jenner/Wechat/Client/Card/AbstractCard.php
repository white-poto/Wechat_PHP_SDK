<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-16
 * Time: 下午12:13
 */

namespace Jenner\Wechat\Client\Card;


use Jenner\Wechat\Client\Client;
use Jenner\Wechat\Config\URI;

abstract class AbstractCard extends Client
{
    public function __construct()
    {
        parent::__construct();
        $this->card_uri_prefix = URI::CARD_PREFIX;
    }
} 