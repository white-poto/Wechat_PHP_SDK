<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-15
 * Time: 上午10:14
 *
 * 商品管理
 */

namespace Jenner\Wechat\Client\Merchant;

use Jenner\Wechat\WechatConfig;

class Good extends AbstractMerchant
{
    /**
     * 新增商品
     * @param $product
     * @return bool|mixed
     */
    public function create($product)
    {
        $uri = $this->merchant_uri_prefix . WechatConfig::MERCHANT_GOOD_CREATE;
        return $this->request_post($uri, $product);
    }

    /**
     * 删除商品
     * @param $product_id
     * @return bool|mixed
     */
    public function del($product_id)
    {
        $uri = $this->merchant_uri_prefix . WechatConfig::MERCHANT_GOOD_DEL;
        return $this->request_post($uri, ['product_id' => $product_id]);
    }

    /**
     * 修改商品
     * @param $product
     * @return bool|mixed
     */
    public function update($product)
    {
        $uri = $this->merchant_uri_prefix . WechatConfig::MERCHANT_GOOD_UPDATE;
        return $this->request_post($uri, $product);
    }

    /**
     * 查询商品
     * @param $product_id
     * @return bool|mixed
     */
    public function get($product_id)
    {
        $uri = $this->merchant_uri_prefix . WechatConfig::MERCHANT_GOOD_GET;
        return $this->request_post($uri, ['product_id' => $product_id]);
    }

    /**
     * 获取指定状态的所有商品
     * @param $status
     * @return bool|mixed
     */
    public function getByStatus($status)
    {
        $uri = $this->merchant_uri_prefix . WechatConfig::MERCHANT_GOOD_GET_BY_STATUS;
        return $this->request_post($uri, ['status' => $status]);
    }

    /**
     * 商品上下架
     * @param $product_id
     * @param $status
     * @return bool|mixed
     */
    public function modStatus($product_id, $status)
    {
        $uri = $this->merchant_uri_prefix . WechatConfig::MERCHANT_GOOD_MOD_STATUS;
        return $this->request_post($uri, ['product_id' => $product_id, 'status' => $status]);
    }


} 