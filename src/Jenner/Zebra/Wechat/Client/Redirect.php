<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-17
 * Time: 下午2:36
 */

namespace Jenner\Zebra\Wechat;


use Jenner\Zebra\Tools\Http;
use Jenner\Zebra\Wechat\Client\BaseClient;
use Jenner\Zebra\Wechat\C;

class Redirect extends BaseClient {

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
        $redirect_uri = C::get('uri.redirect.auth') . '?appid='
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
        $uri = C::get('uri.redirect.token');
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
        $uri = C::get('uri.redirect.user_info');
        $http = new Http($uri);
        $response_json = $http->GET($params);

        return $this->checkResponse($response_json);
    }
} 