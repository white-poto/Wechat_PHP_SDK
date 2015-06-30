<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-14
 * Time: 上午11:05
 */

namespace Jenner\Zebra\Wechat\Client;

use Jenner\Zebra\Wechat\Exception\WechatException;
use Jenner\Zebra\Wechat\Exception\ResponseErrorException;
use Jenner\Zebra\Wechat\WechatConfig;


/**
 * 微信客户端，用于主动向微信发出请求，
 * 由于微信接口参数不规范，需要同时使用get、post请求，该类提供三个接口，分别支持get、post、get&post方式请求
 *
 * 由于请求微信API前，需要首先获取access_token，
 * 为避免每次调用API都先获取access_token，设置以下两个回调函数可以实现对access_token的缓存
 * $get_access_token_callback和$set_access_token_callback是获取和保存access_token的回调函数
 * $get_access_token_callback不需要参数，直接返回access_token
 * $set_access_token_callback接受一个access_token参数，不需要返回值
 *
 * 如果access_token获取失败，则会抛出ResponseErrorException异常
 *
 * Class WechatClient
 * @package Jenner\Zebra\Wechat\Client
 */
class WechatClient {

    //微信API的URI前缀
    protected $uri_prefix;

    //自定义获取access_token函数
    protected static $get_access_token_callback;

    //自定义保存access_token函数
    protected static $set_access_token_callback;

    /**
     * 初始化微信API_URL前缀
     */
    public function __construct(){
        //检查WECHAT_APP_ID是否定义
        if(!defined('WECHAT_APP_ID')){
            throw new WechatException('const WECHAT_APP_ID not defined');
        }
        //检查WECHAT_SECRET常量是否定义
        if(!defined('WECHAT_SECRET')){
            throw new WechatException('const WECHAT_SECRET not defined');
        }

        $this->uri_prefix = WechatConfig::COMMON_PREFIX;
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
     * @param bool $file_upload 是否上传文件
     * @return bool|mixed
     */
    public function request_post($uri, $post_params, $file_upload=false){
        return $this->request($uri, $post_params, $file_upload);
    }

    /**
     * 发起带有GET参数的POST请求
     * @param $uri
     * @param null $post_params POST参数
     * @param null $get_params GET参数
     * @param bool $file_upload 是否上传文件
     * @return bool|mixed
     */
    public function request($uri, $post_params=null, $get_params=null, $file_upload=false){
        $access_token = $this->getAccessToken();
        $get_params['access_token'] = $access_token;
        $query_string = http_build_query($get_params);
        $post_params = json_encode($post_params, JSON_UNESCAPED_UNICODE);
        $http = new \Jenner\Zebra\Tools\Http($uri . '?' . $query_string);
        $result_json = $http->POST($post_params, $file_upload);

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
        if($cache = $this->getAccessTokenAndCheckExpiresIn()) {
            return $cache['access_token'];
        }

        $uri = $this->uri_prefix . WechatConfig::AUTH_TOKEN;
        $params = [
            'grant_type' => 'client_credential',
            'appid' => WECHAT_APP_ID,
            'secret' => WECHAT_SECRET,
        ];
        $http = new \Jenner\Zebra\Tools\Http($uri);
        $response_json = $http->GET($params);
        $this->checkResponse($response_json);
        $result = json_decode($response_json, true);

        $cache['access_token'] = $result['access_token'];
        $cache['expires_in'] = $result['expires_in'];
        $cache['create_time'] = time();
        if(!empty(self::$get_access_token_callback) && is_callable(self::$get_access_token_callback)) {
            call_user_func(self::$set_access_token_callback, $cache);
        }

        return $result['access_token'];
    }

    /**
     * 检查access_key是否过期
     * @return bool
     */
    public function getAccessTokenAndCheckExpiresIn(){
        if(empty(self::$get_access_token_callback) || !is_callable(self::$get_access_token_callback)) return false;
        $cache = call_user_func(self::$get_access_token_callback);

        if(empty($cache)) return false;
        $now = time();
        if($now - $cache['create_time'] > $cache['expires_in']){
            return false;
        }

        return $cache;
    }

    /**
     * 检查微信响应是否出错，如果出错，抛出异常
     * @param $response_json
     * @return mixed
     * @throws \Jenner\Zebra\Wechat\Exception\ResponseErrorException
     */
    public function checkResponse($response_json){
        $response = json_decode($response_json, true);
        if(isset($response['errcode']) && $response['errcode']!=0){
            throw new ResponseErrorException($response['errmsg'], $response['errcode']);
        }

        return $response;
    }
} 