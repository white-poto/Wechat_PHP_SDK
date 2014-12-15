<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-12
 * Time: 上午10:14
 *
 * 微信URL配置类
 */

namespace Jenner\Zebra\Wechat;


class WechatUri
{

    const COMMON_PREFIX = 'https://api.weixin.qq.com/cgi-bin'; //通用API前缀
    /**
     * 验证相关
     */
    const AUTH_TOKEN = '/token'; //获取TOKEN地址
    const AUTH_GET_CALLBACK_IP = '/getcallbackip'; //获取微信服务器IP列表地址

    /**
     * 消息相关
     */
    const MESSAGE_SEND = '/message/custom/send'; //发送客服消息接口地址

    /**
     * 用户管理相关
     */
    const USER_UPDATE_REMARK = '/user/info/updateremark'; //修改关注者备注地址
    const USER_INFO = '/user/info'; //查看关注者信息地址
    const USER_GET = '/user/get'; //获取关注者列表地址

    /**
     * 用户组相关
     */
    const USER_GROUP_CREATE = '/groups/create'; //创建用户组地址
    const USER_GROUP_GET = '/groups/get'; //获取分组列表
    const USER_GROUP_GET_BY_OPEN_ID = '/groups/getid'; //根据OPEN_ID获取用户所属分组
    const USER_GROUP_UPDATE = '/groups/update'; //修改分组名称
    const USER_GROUP_MEMBER_UPDATE = '/groups/members/update'; //移动用户分组

    /**
     * 客服相关
     */
    const CUSTOM_SERVICE_LIST = '/customservice/getkflist'; //获取客服列表
    const CUSTOM_SERVICE_ONLINE_LIST = '/customservice/getonlinekflist'; //获取在线客服接待信息
    const CUSTOM_SERVICE_ADD = '/customservice/kfaccount/add';// 添加客服账号
    const CUSTOM_SERVICE_UPDATE = '/customservice/kfaccount/update'; //设置客服信息
    const CUSTOM_SERVICE_UPLOAD_HEAD_IMG = '/customservice/kfacount/uploadheadimg'; //上传客服头像
    const CUSTOM_SERVICE_DELETE = '/customservice/kfaccount/del'; //删除客服账号
    const CUSTOM_SERVICE_RECORD = '/customservice/getrecord'; //获取客服聊天记录


    //页面重定向相关
    const REDIRECT_TOKEN = 'https://api.weixin.qq.com/sns/oauth2/access_token';
    const REDIRECT_USER_INFO = 'https://api.weixin.qq.com/sns/userinfo';
    const REDIRECT_AUTH = 'https://open.weixin.qq.com/connect/oauth2/authorize';

    /**
     * 菜单相关
     */
    const MENU_CREATE = '/menu/create';
    const MENU_GET = '/menu/get';
    const MENU_DELETE = '/menu/delete';


    /**
     * 语意理解接口
     */
    const SEMANTIC = '/semantic/semproxy/search';

    /**
     * 二维码相关
     */
    const QR_CODE_CREATE = '/qrcode/create'; //创建二维码
    const QR_CODE_DOWNLOAD = '/showqrcode'; //下载二维码

    /**
     * 长连接转短连接
     */
    const SHORT_URL = '/shorturl'; //长连接转短连接

    /**
     * 微小店相关接口
     */
    const MERCHANT_PREFIX = 'https://api.weixin.qq.com/merchant';

    //微小店商品相关
    const MERCHANT_GOOD_CREATE = '/create'; //添加商品
    const MERCHANT_GOOD_DEL = '/del';//删除商品
    const MERCHANT_GOOD_UPDATE = '/update';//修改商品
    const MERCHANT_GOOD_GET = '/get';//查询商品
    const MERCHANT_GOOD_GET_BY_STATUS = '/getbystatus';//根据上下架状态获取商品列表
    const MERCHANT_GOOD_MOD_STATUS = '/modproductstatus';//商品上下架

    //微小店分类相关
    const MERCHANT_CATEGORY_GET_SUB = '/category/getsub'; //获取子分类
    const MERCHANT_CATEGORY_GET_SKU = '/category/getsku'; //获取分类下的sku信息
    const MERCHANT_CATEGORY_GET_PROPERTY = '/category/getproperty'; //获取分类下的属性

    //微小店库存相关
    const MERCHANT_STOCK_ADD = '/stock/add'; //添加库存
    const MERCHANT_STOCK_REDUCE = '/stock/reduce'; //减少库存

    //微小店邮费模相关
    const MERCHANT_EXPRESS_ADD = '/express/add'; // 邮费模板添加
    const MERCHANT_EXPRESS_DEL = '/express/del'; //删除邮费模板
    const MERCHANT_EXPRESS_UPDATE = '/express/update'; //修改邮费模板

    //微小店功能接口相关
    const MERCHANT_COMMON_UPLOAD_IMG = '/common/upload_img'; //上传图片

    //微小店订单相关
    const MERCHANT_ORDER_GET_BY_ID = '/order/getbyid'; //根据ID获取订单
    const MERCHANT_ORDER_GET_BY_FILTER = '/order/getbyfilter'; //根据订单状态/创建时间获取订单详情
    const MERCHANT_ORDER_SET_DELIVERY = '/order/setdelivery'; //设置订单发货信息
    const MERCHANT_ORDER_CLOSE = '/order/close'; //关闭订单

    //微小店货架相关
    const MERCHANT_SHELF_ADD = '/shelf/add'; //添加货架
    const MERCHANT_SHELF_DEL = '/shelf/del'; //删除货架
    const MERCHANT_SHELF_MOD = '/shelf/mod'; //修改货架
    const MERCHANT_SHELF_GET_ALL = '/shelf/getall'; //获取全部货架
    const MERCHANT_SHELF_GET_BY_ID = '/shelf/getbyid'; //根据货架ID获取货架信息
}