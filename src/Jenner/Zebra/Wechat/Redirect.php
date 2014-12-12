<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-17
 * Time: 下午2:36
 * 微信重定向
 */

namespace Jenner\Zebra\Wechat\Client;


use Jenner\Zebra\Tools\Http;
use Jenner\Zebra\Wechat\WechatUri;

class Redirect {

    /**
     * 跳转到微信页面认证APP
     * @param $redirect_uri
     * @return mixed
     */
    public function baseRedirect($redirect_uri){
        $this->redirectToWechat($redirect_uri, 'snsapi_base');
    }

    /**
     * 跳转到用户认证页面
     * @param $redirect_uri
     */
    public function userInfoRedirect($redirect_uri){
        $this->redirectToWechat($redirect_uri, 'snsapi_userinfo');
    }

    //跳转到微信认证
    protected function redirectToWechat($redirect_uri, $scope='snsapi_base'){
        $response_type = 'code';
        $redirect_uri = WechatUri::REDIRECT_AUTH . '?appid='
            . WECHAT_APP_ID  .'&redirect_uri=' .  urlencode($redirect_uri)
            . '&response_type='. $response_type
            . '&scope=' .$scope  . '#wechat_redirect';

        header('Location:' . $redirect_uri);
    }

    public function baseInfo($code){
        $params = [
            'appid' => WECHAT_APP_ID,
            'secret' => WECHAT_SECRET,
            'code' => $code,
            'grant_type' => 'authorization_code',
        ];
        $uri = WechatUri::REDIRECT_TOKEN;
        $http = new Http($uri);
        $response_json = $http->GET($params);

        return $this->checkResponse($response_json);
    }

    public function userInfo($access_token, $openid, $lang='zh_CN'){
        $params = [
            'access_token' => $access_token,
            'openid' => $openid,
            'lang' => $lang,
        ];
        $uri = WechatUri::REDIRECT_USER_INFO;
        $http = new Http($uri);
        $response_json = $http->GET($params);

        $response = json_decode($response_json, true);
        if(isset($response['errcode'])){
            throw new ResponseErrorException($response['errmsg'], $response['errcode']);
        }

        return $response;
    }
} 