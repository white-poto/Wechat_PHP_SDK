<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-14
 * Time: 上午11:05
 */

namespace Jenner\Zebra\Wechat\Client;

use Jenner\Zebra\Wechat\C;


class WechatClient extends BaseClient {

    /**
     * @var
     */
    protected $uri_prefix;

    protected $uri_config;

    protected static $access_token_callback;


    /**
     * 初始化微信API_URL前缀
     */
    public function __construct(){
        $this->uri_prefix = C::get('uri.prefix');
    }

    public static function setAccessTokenCallback($callback){
        self::$access_token_callback = $callback;
    }

    /**
     * 发起普通GET请求
     * @param $uri
     * @param null $params
     * @return bool|mixed
     */
    public function request_get($uri, $params=null){
        return $this->request($uri, null, $params);
    }

    /**
     * 发起POST请求
     * @param $uri
     * @param $post_params
     * @return bool|mixed
     */
    public function request_post($uri, $post_params){
        return $this->request($uri, $post_params);
    }

    /**
     * 发起带有GET参数的POST请求
     * @param $uri
     * @param null $post_params
     * @param null $get_params
     * @return bool|mixed
     */
    public function request($uri, $post_params=null, $get_params=null){
        //判断用户是否设定了自己的access_token回调函数，有的话则调用
        if(!empty(self::$access_token_callback) && is_callable(self::$access_token_callback)){
            $access_token = call_user_func(self::$access_token_callback);
        }else{
            $access_token = $this->getAccessToken();
        }

        $get_params['access_token'] = $access_token;
        $query_string = http_build_query($get_params);
        $http = new \Jenner\Zebra\Tools\Http($uri . '?' . $query_string);
        $result_json = $http->POST($post_params);

        //存在errcode并且errcode不为0时，为错误返回
        return $this->checkResponse($result_json);
    }

    /**
     * 获取微信access_key
     * @throws \Exception
     * @internal param $app_id
     * @internal param $secret
     * @return mixed
     */
    public function getAccessToken(){
        if($this->checkAccessTokenExpiresIn()) {
            return $_ENV['wechat']['access_token'];
        }

        $uri = $this->uri_prefix . C::get('uri.auth.token');
        $params = [
            'grant_type' => 'client_credential',
            'appid' => WECHAT_APP_ID,
            'secret' => WECHAT_SECRET,
        ];
        $http = new \Jenner\Zebra\Tools\Http($uri);
        $result_json = $http->GET($params);
        $result = json_decode($result_json, true);
        if(isset($result['errcode'])){
            $this->error_code = $result['errcode'];
            $this->error_message = $result['errmsg'];
            return false;
        }

        $_ENV['wechat']['access_token'] = $result['access_token'];
        $_ENV['wechat']['expires_in'] = $result['expires_in'];
        $_ENV['wechat']['create_time'] = time();

        return $result['access_token'];
    }

    /**
     * 检查access_key是否过期
     * @return bool
     */
    public function checkAccessTokenExpiresIn(){
        if(!isset($_ENV['wechat'])) return false;
        $now = time();
        if($now - $_ENV['wechat']['create_time'] > $_ENV['wechat']['expires_in']){
            return false;
        }

        return true;
    }
} 