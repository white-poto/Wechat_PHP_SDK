<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-17
 * Time: 上午11:34
 *
 * 微信接口URI不规范，在这里进行统一配置
 */

return [
    //微信API_URI统一前缀
    'prefix' => 'https://api.weixin.qq.com/cgi-bin',

    //验证相关
    'auth' => [
        //获取token地址
        'token' => '/token',
        //获取微信服务器IP列表
        'getcallbackip' => '/getcallbackip',
    ],

    //消息接口
    'message' => [
        //发送客服消息 接口地址
        'custom_send' => '/message/custom/send',
    ],

    //用户相关
    'user' => [
        //创建用户组
        'group_create' => '/groups/create',
        //修改关注备注
        'update_remark' => '/user/info/updateremark',
        //查看关注者信息
        'info' => '/user/info',
        //获取关注者列表
        'get' => '/user/get',
    ],

    'redirect' => [
        'token' => 'https://api.weixin.qq.com/sns/oauth2/access_token',
        'user_info' => 'https://api.weixin.qq.com/sns/userinfo',
        'auth' => 'https://open.weixin.qq.com/connect/oauth2/authorize',
    ],
];
