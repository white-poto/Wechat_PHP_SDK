<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-15
 * Time: 上午10:46
 */

namespace Jenner\Zebra\Wechat\Client\Merchant;


use Jenner\Zebra\Wechat\WechatConfig;

class Stock extends BaseMerchant
{
    /**
     * 增加库存
     * @param $product_id
     * @param $quantity
     * @param $sku_info
     * @return bool|mixed
     */
    public function add($product_id, $quantity, $sku_info)
    {
        $uri = $this->uri_prefix . WechatConfig::MERCHANT_STOCK_ADD;
        $params = [
            'product_id' => $product_id,
            'quantity' => $quantity,
            'sku_info' => $sku_info,
        ];
        return $this->request_post($uri, $params);
    }
} 