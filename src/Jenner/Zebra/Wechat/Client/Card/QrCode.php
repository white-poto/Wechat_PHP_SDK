<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-16
 * Time: 下午2:31
 */

namespace Jenner\Zebra\Wechat\Client\Card;


use Jenner\Zebra\Wechat\WechatConfig;

class QrCode extends BaseCard
{
    /**
     * 生成卡券二维码
     * @param $qr_code
     * @return bool|mixed
     */
    public function create($qr_code)
    {
        $uri = $this->uri_prefix . WechatConfig::CARD_QR_CODE_CREATE;
        return $this->request_post($uri, $qr_code);
    }


} 