<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-17
 * Time: 下午2:36
 * 微信重定向
 */

namespace Jenner\Zebra\Wechat;


use Jenner\Zebra\Tools\Http;
use Jenner\Zebra\Wechat\Exception\WechatException;
use Jenner\Zebra\Wechat\Exception\ResponseErrorException;

class Redirect
{

    public function __construct()
    {
        //检查WECHAT_APP_ID是否定义
        if (!defined('WECHAT_APP_ID')) {
            throw new WechatException('const WECHAT_APP_ID not defined');
        }
        //检查WECHAT_SECRET常量是否定义
        if (!defined('WECHAT_SECRET')) {
            throw new WechatException('const WECHAT_SECRET not defined');
        }
    }

    /**
     * 跳转到微信页面认证APP
     * @param $redirect_uri
     * @return mixed
     */
    public function baseRedirect($redirect_uri)
    {
        $this->redirectToWechat($redirect_uri, 'snsapi_base');
    }

    /**
     * 跳转到用户认证页面
     * @param $redirect_uri
     */
    public function userInfoRedirect($redirect_uri)
    {
        $this->redirectToWechat($redirect_uri, 'snsapi_userinfo');
    }

    //跳转到微信认证
    protected function redirectToWechat($redirect_uri, $scope = 'snsapi_base')
    {
        $response_type = 'code';
        $redirect_uri = WechatConfig::REDIRECT_AUTH . '?appid='
            . WECHAT_APP_ID . '&redirect_uri=' . urlencode($redirect_uri)
            . '&response_type=' . $response_type
            . '&scope=' . $scope . '#wechat_redirect';

        header('Location:' . $redirect_uri);
    }

    public function baseInfo($code)
    {
        $params = [
            'appid' => WECHAT_APP_ID,
            'secret' => WECHAT_SECRET,
            'code' => $code,
            'grant_type' => 'authorization_code',
        ];
        $uri = WechatConfig::REDIRECT_TOKEN;
        $http = new Http($uri);
        $response_json = $http->GET($params);

        return $this->checkResponse($response_json);
    }

    public function userInfo($access_token, $openid, $lang = 'zh_CN')
    {
        $params = [
            'access_token' => $access_token,
            'openid' => $openid,
            'lang' => $lang,
        ];
        $uri = WechatConfig::REDIRECT_USER_INFO;
        $http = new Http($uri);
        $response_json = $http->GET($params);

        $response = json_decode($response_json, true);
        if (isset($response['errcode'])) {
            throw new ResponseErrorException($response['errmsg'], $response['errcode']);
        }

        return $response;
    }

    /**
     * 检查微信响应是否出错，如果出错，抛出异常
     * @param $response_json
     * @return mixed
     * @throws \Jenner\Zebra\Wechat\Exception\ResponseErrorException
     */
    public function checkResponse($response_json)
    {
        $response = json_decode($response_json, true);
        if (isset($response['errcode'])) {
            throw new ResponseErrorException($response['errmsg'], $response['errcode']);
        }

        return $response;
    }
} 