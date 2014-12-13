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
}