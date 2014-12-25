<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-15
 * Time: 上午11:26
 */

namespace Jenner\Zebra\Wechat\Client\Merchant;


use Jenner\Zebra\Wechat\WechatUri;

class Order extends BaseMerchant
{
    /**
     * 根据订单ID获取订单信息
     * @param $order_id
     * @return bool|mixed
     */
    public function getById($order_id)
    {
        $uri = $this->merchant_uri_prefix . WechatUri::MERCHANT_ORDER_GET_BY_ID;
        return $this->request_post($uri, ['order_id' => $order_id]);
    }

    /**
     * 根据订单状态/创建时间获取订单详情
     */
    public function getByFilter($status=null, $begin_time=null, $end_time=null)
    {
        $uri = $this->merchant_uri_prefix . WechatUri::MERCHANT_ORDER_GET_BY_FILTER;
        is_null($status) ? '' : $params['status'] = $status;
        is_null($begin_time) ? '' : $params['begintime'] = $begin_time;
        is_null($end_time) ? '' : $params['endtime'] = $end_time;

        return $this->request_post($uri, $params);
    }

    /**
     * 设置订单发货信息
     * @param $order_id 订单ID
     * @param $delivery_company 物流公司ID(参考《物流公司ID》
     * @param $delivery_track_no 运单ID
     * @param $need_delivery 商品是否需要物流(0-不需要，1-需要，无该字段默认为需要物流)
     * @param $is_others 是否为6.4.5表之外的其它物流公司(0-否，1-是，无该字段默认为不是其它物流公司)
     * @return bool|mixed
     */
    public function setDelivery($order_id, $delivery_company, $delivery_track_no, $need_delivery, $is_others)
    {
        $uri = $this->merchant_uri_prefix . WechatUri::MERCHANT_ORDER_SET_DELIVERY;
        $params = compact('order_id', 'delivery_company', 'delivery_track_no', 'need_delivery', 'is_others');
        return $this->request_post($uri, $params);
    }

    /**
     * 关闭订单
     * @param $order_id 订单ID
     * @return bool|mixed
     */
    public function close($order_id)
    {
        $uri = $this->merchant_uri_prefix . WechatUri::MERCHANT_ORDER_CLOSE;
        return $this->request_post($uri, ['order_id' => $order_id]);
    }
} 