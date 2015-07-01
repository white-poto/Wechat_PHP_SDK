<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-12
 * Time: 上午10:14
 *
 * 微信URL配置类
 */

namespace Jenner\Wechat\Config;


class URI
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
    const CUSTOM_SERVICE_ADD = '/customservice/kfaccount/add'; // 添加客服账号
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
    const MERCHANT_GOOD_DEL = '/del'; //删除商品
    const MERCHANT_GOOD_UPDATE = '/update'; //修改商品
    const MERCHANT_GOOD_GET = '/get'; //查询商品
    const MERCHANT_GOOD_GET_BY_STATUS = '/getbystatus'; //根据上下架状态获取商品列表
    const MERCHANT_GOOD_MOD_STATUS = '/modproductstatus'; //商品上下架

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

    //media素材相关
    const MEDIA_UPLOAD = '/media/upload'; //上传多媒体素材
    const MEDIA_DOWNLOAD = '/media/get'; //下载多媒体素材

    /**
     * 微信卡卷相关接口
     */
    const CARD_PREFIX = 'https://api.weixin.qq.com/card'; //卡卷功能API的URI前缀

    //卡卷相关
    const CARD_CREATE = '/create'; //创建卡券
    const CARD_GET = '/get'; //查询卡券详情
    const CARD_UPDATE = '/update'; //更改卡券信息接口
    const CARD_BATCH_GET = '/batchget'; //更改卡券信息接口

    //门店相关
    const CARD_LOCATION_BATCH_ADD = '/location/batchadd'; //批量导入门店信息
    const CARD_LOCATION_BATCH_GET = '/location/batchget'; //拉取门店列表

    //颜色相关
    const CARD_COLOR_GET = '/getcolors'; //获取颜色列表接口

    //二维码相关
    const CARD_QR_CODE_CREATE = '/qrcode/create'; //生成卡券二维码

    const CARD_CODE_CONSUME = '/code/consume'; //卡券核销部分
    const CARD_CODE_DECRYPT = '/code/decrypt'; //code解码接口
    const CARD_CODE_GET = '/code/get'; //查询code
    const CARD_CODE_BATCH_GET = '/card/batchget'; //批量查询卡列表
    const CARD_CODE_UPDATE = '/code/update'; //更改code
    const CARD_CODE_UNAVAILABLE = '/code/unavailable'; //设置卡券失效接口

    //白名单相关
    const CARD_TEST_WHITE_LIST = '/testwhitelist/set'; //设置测试用户白名单

    //会员卡相关
    const CARD_MEMBER_ACTIVATE = '/membercard/activate'; //激活/绑定会员卡
    const CARD_MEMBER_UPDATE = '/membercard/updateuser'; //会员卡交易 会员卡交易后每次积分及余额变更需通过接口通知微信，便于后续消息通知及其他扩展功能。
    const CARD_MOVIE_TICKET = '/movieticket/updateuser'; //领取电影票后通过调用“更新电影票”接口 update 电影信息及用户选座信息。
    const CARD_BOARDING_PASS_CHECK_IN = '/boardingpass/checkin'; //在线选座
    const CARD_LUCKY_MONEY_UPDATE_USER_BALANCE = '/luckymoney/updateuserbalance'; //更新红包金额

    const TICKET_GET_TICKET = '/ticket/getticket';

}