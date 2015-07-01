<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-15
 * Time: 上午10:39
 */

namespace Jenner\Wechat\Client\Merchant;


use Jenner\Wechat\Config\URI;

class Category extends AbstractMerchant
{
    /**
     * 获取指定分类的所有子分类
     * @param $category_id
     * @return bool|mixed
     */
    public function getSub($category_id)
    {
        $uri = $this->merchant_uri_prefix . URI::MERCHANT_CATEGORY_GET_SUB;
        return $this->request_post($uri, ['cate_id' => $category_id]);
    }

    /**
     * 获取指定子分类的所有SKU
     * @param $category_id
     * @return bool|mixed
     */
    public function getSku($category_id)
    {
        $uri = $this->merchant_uri_prefix . URI::MERCHANT_CATEGORY_GET_SKU;
        return $this->request_post($uri, ['cate_id' => $category_id]);
    }

    /**
     * 获取指定分类的所有属性
     * @param $category_id
     * @return bool|mixed
     */
    public function getProperty($category_id)
    {
        $uri = $this->merchant_uri_prefix . URI::MERCHANT_CATEGORY_GET_PROPERTY;
        return $this->request_post($uri, ['cate_id' => $category_id]);
    }


} 