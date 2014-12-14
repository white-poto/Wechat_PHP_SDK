<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-11
 * Time: 下午5:52
 */

namespace Jenner\Zebra\Wechat;

use Jenner\Zebra\Wechat\Exception\WechatException;
use Jenner\Zebra\Wechat\Request\XmlRequest;
use Jenner\Zebra\Wechat\Response\XmlResponse;


/**
 * 微信推送接收器
 * 你需要继承该抽象类，并实现其抽象方法
 * 对于不同的微信推送，你需要调用listen和unListen函数进行绑定和解绑定
 *
 * 该类提供一个before和after，如果你需要在处理微信推送之前或之后做一些处理，可以在你的类中实现这两个方法
 * 如果没有实现before和after，则不会调用
 * before接收一个数组参数，该数组为微信推送请求信息
 * after接收两个参数，request和result，request为微信推送请求信息，result为你注册的处理函数的返回值
 *
 * 微信消息推送列表(不区分大小写)：
 * text
 * image
 * voice
 * location
 * link
 *
 * 微信事件推送列表
 * subscribe
 * unsubscribe
 * SCAN
 * LOCATION
 * CLICK
 * VIEW
 * scancode_push
 * scancode_waitmsg
 * pic_sysphoto
 * pic_photo_or_album
 * pic_weixin
 * location_select
 *
 * Class WechatServer
 * @package Jenner\Zebra\Wechat
 */
abstract class WechatServer
{
    /**
     * 微信账号的token，验证消息真实性时需要用到
     */
    protected $token;

    /**
     * 微信发送的请求包，数组格式，下标统一转换为了小写
     */
    protected $request;


    /**
     * 微信推送回调函数数组
     */
    protected $callback;

    /**
     * 构造函数
     * @param $token 微信账号的token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * 注册推送事件回调函数
     * @param $event
     * @param $callback
     */
    public function listen($event, $callback){
        $event = strtolower($event);
        $this->callback[$event] = $callback;
    }

    /**
     * 解除推送事件回调函数
     * @param $event
     */
    public function unListen($event){
        $event = strtolower($event);
        unset($this->callback[$event]);
    }

    /**
     * 微信消息、时间推送执行入口
     */
    public function start()
    {
        //验证是否为微信验证服务器
        if ($this->isValid()) {
            echo $_GET['echostr'];
            return;
        }

        //验证是否是微信发来的请求
        if (!$this->validateSignature($this->token)) {
            throw new WechatException('wechat request Illegal');
        }

        if (!isset($GLOBALS['HTTP_RAW_POST_DATA'])) {
            throw new WechatException('HTTP_RAW_POST_DATA empty');
        }

        $request_xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $request = XmlRequest::toArray($request_xml);
        //将下标统一转换为小写，获取信息统一使用$this->getRequest('field_name');
        $this->request = array_change_key_case($request, CASE_LOWER);

        if(method_exists($this, 'before') && is_callable([$this, 'before'])){
            $this->before($this->request);
        }

        if($this->getMsgType() == 'event'){
            $event_type = $this->getEvent();
            $event_type = strtolower($event_type);
            if(!empty($this->callback[$event_type]) && is_callable($this->callback[$event_type])){
                $result = call_user_func($this->callback[$event_type], $this->request);
            }else{
                $result = $this->onUnListenEvent($this->request);
            }
        }else{
            $message_type = $this->getMsgType();
            $message_type = strtolower($message_type);
            if(!empty($this->callback[$message_type]) && is_callable($this->callback[$message_type])){
                $result = call_user_func($this->callback[$message_type], $this->request);
            }else{
                $result = $this->onUnListenedMessage($this->request);
            }
        }

        if(method_exists($this, 'after') && is_callable([$this, 'after'])){
            $this->after($this->request, $result);
        }

    }


    /**
     * 未知消息类型处理
     * @param $request
     * @return mixed
     */
    abstract public function onUnListenedMessage($request);


    /**
     * 未知事件推送处理
     * @param $request
     * @return mixed
     */
    abstract public function onUnListenEvent($request);

    /**
     * 向服务器发送消息
     * @param XmlResponse $response
     */
    public function send(XmlResponse $response)
    {
        $message = $response->create();
        echo $message;
        return;
    }

    /**
     * 获取本次请求中的参数，不区分大小
     *
     * @param bool|string $param 参数名，默认为无参
     * @return mixed
     */
    protected function getRequest($param = FALSE)
    {
        if ($param === FALSE) {
            return $this->request;
        }
        $param = strtolower($param);
        if (isset($this->request[$param])) {
            return $this->request[$param];
        }
        return NULL;
    }

    /**
     * 获取消息发送者open_id
     * @return mixed
     */
    protected function getFromUserName()
    {
        return $this->getRequest('FromUserName');
    }

    /**
     * 获取消息接受者（一般是自己）的open_id
     * @return mixed
     */
    protected function getToUserName()
    {
        return $this->getRequest('ToUserName');
    }

    /**
     * 获取消息创建时间
     * @return mixed
     */
    protected function getCreateTime()
    {
        return $this->getRequest('CreateTime');
    }

    /**
     * 获取消息类型
     * @return mixed
     */
    protected function getMsgType()
    {
        return $this->getRequest('MsgType');
    }

    /**
     * 获取事件名称
     * @return mixed
     */
    protected function getEvent()
    {
        return $this->getRequest('Event');
    }

    /**
     * 获取消息ID
     * @return mixed
     */
    protected function getMsgId()
    {
        return $this->getRequest('MsgId');
    }

    /**
     * 验证消息真实性
     *
     * @param  string $token 验证信息
     * @return boolean
     */
    public function validateSignature($token)
    {
        if (!(isset($_GET['signature']) && isset($_GET['timestamp']) && isset($_GET['nonce']))) {
            return FALSE;
        }

        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        $signatureArray = [$token, $timestamp, $nonce];
        sort($signatureArray, SORT_STRING);
        return sha1(implode($signatureArray)) == $signature;
    }

    /**
     * 修改微信API配置时，微信会发送验证到URL
     * 判断此次请求是否为验证请求
     * 如果是，你需要在上层直接输出原始的echostr并返回
     *
     * @return boolean
     */
    public function isValid()
    {
        return isset($_GET['echostr']);
    }
}
