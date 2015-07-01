<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/1
 * Time: 14:07
 */

namespace Jenner\Wechat\Config;
/**
 * 微信事件推送列表
 * subscribe 关注事件
 * unsubscribe 取消关注事件
 * SCAN 扫描带参数二维码事件
 * LOCATION 上报地理位置事件
 * CLICK 点击菜单拉取消息时的事件推送
 * VIEW 点击菜单跳转链接时的事件推送
 * scancode_push 扫码推事件的事件推送
 * scancode_waitmsg 扫码推事件且弹出“消息接收中”提示框的事件推送
 * pic_sysphoto 弹出系统拍照发图的事件推送
 * pic_photo_or_album 弹出拍照或者相册发图的事件推送
 * pic_weixin 弹出微信相册发图器的事件推送
 * location_select 弹出地理位置选择器的事件推送
 * merchant_order 订单付款时间
 *
 * card_pass_check 生成的卡券通过审核
 * card_not_pass_check 卡券未通过审核
 * user_get_card 用户领取卡券
 * user_del_card 用户删除卡券
 *
 * 自定义事件
 * unknown_event 未知事件推送
 * unknown_message 未知消息推送
 */

class Event {
    const UNKNOWN_EVENT = 'unknown_event';
    const UNKNOWN_MESSAGE = 'unknown_message';

    const SUBSCRIBE = 'subscribe';
    const UNSUBSCRIBE = 'unsubscribe';
    const SCAN = 'scan';
}