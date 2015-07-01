<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-15
 * Time: 上午10:46
 */

namespace Jenner\Wechat\Client\Merchant;


use Jenner\Wechat\Config\URI;

class Stock extends AbstractMerchant
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
        $uri = $this->merchant_uri_prefix . URI::MERCHANT_STOCK_ADD;
        $params = [
            'product_id' => $product_id,
            'quantity' => $quantity,
            'sku_info' => $sku_info,
        ];
        return $this->request_post($uri, $params);
    }
} 