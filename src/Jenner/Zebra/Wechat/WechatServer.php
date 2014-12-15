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
 * 对于不同的微信推送，你需要调用on和off函数进行绑定和解绑定
 *
 * 你可以注册以下事件处理监听，未知消息和未知事件处理可以分别注册unknown_message和unknown_event处理
 * 同时你可以注册before和after函数，分别在时间开始处理前和处理后，做一些其他事情
 * 除after函数外，这些会回调函数都必须接受两个函数WechatServer $server, $request.$server是WechatServer实例，
 * 可以通过$server->send方法向微信返回消息
 * $request是微信请求的信息，
 * 同时你也可以通过$server->getRequest方法读取request中的信息，另种方式任你选择
 *
 * 微信消息推送列表(不区分大小写)：
 * text
 * image
 * voice
 * location
 * link
 *
 *
 * 微信事件推送列表
 * subscribe 关注事件
 * unsubscribe 取消关注事件
 * SCAN 扫描带参数二维码事件
 * LOCATION 上报地理位置事件
 * CLICK 点击菜单拉取消息时的事件推送
 * VIEW 点击菜单跳转链接时的事件推送
 * scancode_push 扫码推事件的事件推送
 * scancode_waitmsg 扫码推事件且弹出“消息接收中”提示框的事件推送
 * pic_sysphoto 弹出系统拍照发图的事件推送
 * pic_photo_or_album 弹出拍照或者相册发图的事件推送
 * pic_weixin 弹出微信相册发图器的事件推送
 * location_select 弹出地理位置选择器的事件推送
 * merchant_order 订单付款时间
 *
 * 自定义事件
 * unknown_event 未知事件推送
 * unknown_message 未知消息推送
 *
 * Class WechatServer
 * @package Jenner\Zebra\Wechat
 */
class WechatServer
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
    public function on($event, $callback){
        $event = strtolower($event);
        $this->callback[$event] = $callback;
    }

    /**
     * 解除推送事件回调函数
     * @param $event
     */
    public function off($event){
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

        if(!empty($this->callback['before']) && is_callable($this->callback['before'])){
            $result = call_user_func($this->callback['before'], $this, $request);
        }

        if($this->getMsgType() == 'event'){
            $event_type = $this->getEvent();
            $event_type = strtolower($event_type);
            if(!empty($this->callback[$event_type]) && is_callable($this->callback[$event_type])){
                $result = call_user_func($this->callback[$event_type], $this, $request);
            }else{
                if(!empty($this->callback['unknown_message']) && is_callable($this->callback['unknown_message'])){
                    $result = call_user_func($this->callback['unknown_message'], $this, $request);
                }
            }
        }else{
            $message_type = $this->getMsgType();
            $message_type = strtolower($message_type);
            if(!empty($this->callback[$message_type]) && is_callable($this->callback[$message_type])){
                $result = call_user_func($this->callback[$message_type], $this, $request);
            }else{
                if(!empty($this->callback['unknown_event']) && is_callable($this->callback['unknown_event'])){
                    $result = call_user_func($this->callback['unknown_event'], $this, $request);
                }
            }
        }

        if(!empty($this->callback['before']) && is_callable($this->callback['before'])){
            call_user_func($this->callback['before'], $this, $result);
        }

    }

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
    public function getRequest($param = FALSE)
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
    public function getFromUserName()
    {
        return $this->getRequest('FromUserName');
    }

    /**
     * 获取消息接受者（一般是自己）的open_id
     * @return mixed
     */
    public function getToUserName()
    {
        return $this->getRequest('ToUserName');
    }

    /**
     * 获取消息创建时间
     * @return mixed
     */
    public function getCreateTime()
    {
        return $this->getRequest('CreateTime');
    }

    /**
     * 获取消息类型
     * @return mixed
     */
    public function getMsgType()
    {
        return $this->getRequest('MsgType');
    }

    /**
     * 获取事件名称
     * @return mixed
     */
    public function getEvent()
    {
        return $this->getRequest('Event');
    }

    /**
     * 获取消息ID
     * @return mixed
     */
    public function getMsgId()
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
