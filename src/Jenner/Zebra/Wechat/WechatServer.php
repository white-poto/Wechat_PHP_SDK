<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-11
 * Time: 下午5:52
 */

namespace Jenner\Zebra\Wechat;

use Jenner\Zebra\Wechat\Exception\IllegalPushRequestException;
use Jenner\Zebra\Wechat\Exception\PostDataEmptyException;
use Jenner\Zebra\Wechat\Request\XmlRequest;
use Jenner\Zebra\Wechat\Response\XmlResponse;

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
     * 构造函数
     * @param $token 微信账号的token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * 微信消息、时间推送执行入口
     * @throws Exception\IllegalPushRequestException
     * @throws Exception\PostDataEmptyException
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
            throw new IllegalPushRequestException();
        }

        if (!isset($GLOBALS['HTTP_RAW_POST_DATA'])) {
            throw new PostDataEmptyException();
        }

        $request_xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $request = XmlRequest::toArray($request_xml);
        //将下标统一转换为小写，获取信息统一使用$this->getRequest('field_name');
        $this->request = array_change_key_case($request, CASE_LOWER);

        switch ($this->getMsgType()) {
            case 'text' :
                $this->onText();
                break;
            case 'image' :
                $this->onImage();
                break;
            case 'voice' :
                $this->onVoice();
                break;
            case 'location' :
                $this->onLocation();
                break;
            case 'link' :
                $this->onLink();
                break;
            case 'event' :
            {
                switch ($this->getEvent()) {
                    case 'subscribe':
                        //扫描二维码关注
                        if(!is_null($this->getRequest('TICKET'))){
                            $this->onEventScanSubScribe();
                        }else{//普通关注
                            $this->onEventSubscribe();
                        }
                        break;
                    case 'unsubscribe':
                        $this->onEventUnSubScribe();
                        break;
                    case 'SCAN':
                        $this->onEventScan();
                        break;
                    case 'LOCATION':
                        $this->onEventLocation();
                        break;
                    case 'CLICK':
                        $this->onEventClick();
                        break;
                    case 'VIEW' :
                        $this->onEventView();
                        break;
                    default :
                        $this->onUnknownEvent();
                        break;
                }
                break;
            }
            default :
                $this->onUnknownMessage();
                break;
        }
    }

    /**
     * 文本消息推送
     * @return mixed
     */
    abstract public function onText();

    /**
     * 图片消息推送
     * @return mixed
     */
    abstract public function onImage();

    /**
     * 语音消息推送
     * @return mixed
     */
    abstract public function onVoice();

    /**
     * 视频消息推送
     * @return mixed
     */
    abstract public function onVideo();

    /**
     * 地理位置消息推送
     * @return mixed
     */
    abstract public function onLocation();

    /**
     * 链接消息推送
     * @return mixed
     */
    abstract public function onLink();

    /**
     * 未知消息类型处理
     * @return mixed
     */
    abstract public function onUnknownMessage();

    /**
     * 普通关注事件推送（不包含扫描二维码关注事件）
     * @return mixed
     */
    abstract public function onEventSubscribe();

    /**
     * 取消关注推送
     * @return mixed
     */
    abstract public function onEventUnSubScribe();

    /**
     * 扫描二维码关注时推送
     * @return mixed
     */
    abstract public function onEventScanSubScribe();

    /**
     * 用户已关注时扫描二维码的事件推送
     * @return mixed
     */
    abstract public function onEventScan();

    /**
     * 上报地理位置事件推送
     * @return mixed
     */
    abstract public function onEventLocation();

    /**
     * 点击菜单拉取消息时的事件推送
     * @return mixed
     */
    abstract public function onEventClick();

    /**
     * 点击菜单跳转链接时的事件推送
     * @return mixed
     */
    abstract public function onEventView();

    /**
     * @return mixed
     */
    abstract public function onUnknownEvent();

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
