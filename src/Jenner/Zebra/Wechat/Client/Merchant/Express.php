<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-15
 * Time: 上午11:00
 */

namespace Jenner\Zebra\Wechat\Client\Merchant;


use Jenner\Zebra\Wechat\WechatConfig;

class Express extends BaseMerchant
{
    /**
     * 增加邮费模板
     * @param $express
     * @return bool|mixed
     */
    public function add($express)
    {
        $uri = $this->uri_prefix . WechatConfig::MERCHANT_EXPRESS_ADD;
        return $this->request_post($uri, $express);
    }

    /**
     * 删除邮费模板
     * @param $template_id
     * @return bool|mixed
     */
    public function del($template_id)
    {
        $uri = $this->uri_prefix . WechatConfig::MERCHANT_EXPRESS_DEL;
        return $this->request_post($uri, compact('template_id'));
    }

} 