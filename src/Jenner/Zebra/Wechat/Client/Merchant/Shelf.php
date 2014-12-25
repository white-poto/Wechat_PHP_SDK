<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-15
 * Time: 下午3:42
 *
 * 货架管理
 */

namespace Jenner\Zebra\Wechat\Client\Merchant;

use Jenner\Zebra\Wechat\Client\WechatClient;
use Jenner\Zebra\Wechat\WechatUri;

class Shelf extends BaseMerchant
{

    /**
     * 添加货架
     * @param $shelf
     * @return bool|mixed
     */
    public function add($shelf)
    {
        $uri = $this->merchant_uri_prefix . WechatUri::MERCHANT_SHELF_ADD;
        return $this->request_post($uri, $shelf);
    }

    /**
     * 删除货架
     * @param $shelf_id 货架ID
     * @return bool|mixed
     */
    public function del($shelf_id)
    {
        $uri = $this->merchant_uri_prefix . WechatUri::MERCHANT_SHELF_DEL;
        return $this->request_post($uri, compact('shelf_id'));
    }

    /**
     * 修改货架
     * @param $shelf
     * @return bool|mixed
     */
    public function update($shelf)
    {
        $uri = $this->merchant_uri_prefix . WechatUri::MERCHANT_SHELF_MOD;
        return $this->request_post($uri, $shelf);
    }

    /**
     * 获取所有货架
     * @return bool|mixed
     */
    public function getAll()
    {
        $uri = $this->merchant_uri_prefix . WechatUri::MERCHANT_SHELF_GET_ALL;
        return $this->request_get($uri);
    }

    /**
     * 根据货架ID获取货架信息
     * @param $shelf_id
     * @return bool|mixed
     */
    public function getById($shelf_id)
    {
        $uri = $this->merchant_uri_prefix . WechatUri::MERCHANT_SHELF_GET_BY_ID;
        return $this->request_post($uri, compact('shelf_id'));
    }
} 