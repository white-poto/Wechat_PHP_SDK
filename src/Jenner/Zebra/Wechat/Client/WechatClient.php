<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-14
 * Time: 上午11:05
 */

namespace Jenner\Zebra\Wechat\Client;

use Jenner\Zebra\Wechat\C;
use Jenner\Zebra\Wechat\WechatUri;


/**
 * 微信客户端，用于主动向微信发出请求，
 * 由于微信接口参数不规范，需要同时使用get、post请求，该类提供三个接口，分别支持get、post、get&post方式请求
 * Class WechatClient
 * @package Jenner\Zebra\Wechat\Client
 */
class WechatClient extends BaseClient {

    /**
     * @var
     */
    protected $uri_prefix;

    /**
     * @var
     */
    protected $uri_config;

    //自定义获取access_token函数
    /**
     * @var
     */
    protected static $get_access_token_callback;
    //自定义保存access_token函数
    /**
     * @var
     */
    protected static $set_access_token_callback;


    /**
     * 初始化微信API_URL前缀
     */
    public function __construct(){
        $this->uri_prefix = WechatUri::COMMON_PREFIX;
    }

    /**
     * @param $callback
     */
    public static function registerGetAccessTokenCallback($callback){
        self::$get_access_token_callback = $callback;
    }

    /**
     * @param $callback
     */
    public static function registerSetAccessTokenCallback($callback){
        self::$set_access_token_callback = $callback;
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
         $access_token = $this->getAccessToken();

        $get_params['access_token'] = $access_token;
        $query_string = http_build_query($get_params);
        $http = new \Jenner\Zebra\Tools\Http($uri . '?' . $query_string);
        $post_params = json_encode($post_params, JSON_UNESCAPED_UNICODE);
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
        if($cache = $this->checkAccessTokenExpiresIn()) {
            return $cache['access_token'];
        }

        $uri = $this->uri_prefix . WechatUri::AUTH_TOKEN;
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

        $cache['access_token'] = $result['access_token'];
        $cache['expires_in'] = $result['expires_in'];
        $cache['create_time'] = time();
        call_user_func(self::$set_access_token_callback, $cache);

        return $result['access_token'];
    }

    /**
     * 检查access_key是否过期
     * @return bool
     */
    public function checkAccessTokenExpiresIn(){
        if(empty(self::$get_access_token_callback) || !is_callable(self::$get_access_token_callback)) return false;
        $cache = call_user_func(self::$get_access_token_callback);

        if(empty($cache)) return false;
        $now = time();
        if($now - $cache['create_time'] > $cache['expires_in']){
            return false;
        }

        return $cache;
    }
} 