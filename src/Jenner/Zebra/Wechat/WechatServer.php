<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-11
 * Time: 下午5:52
 */

namespace Jenner\Zebra\Wechat\Server;

use Jenner\Zebra\Wechat\Exception\IllegalPushRequest;
use Jenner\Zebra\Wechat\Exception\PostDataEmpty;
use Jenner\Zebra\Wechat\Request\XmlRequest;

abstract class WechatServer
{
    protected $token;

    protected $request;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function start()
    {
        //验证是否为微信验证服务器
        if ($this->isValid()) {
            echo Input::get('echostr');
            return;
        }

        //验证是否是微信发来的请求
        if ($this->validateSignature($this->token)) {
            throw new IllegalPushRequestException();
        }

        if (!isset($GLOBALS['HTTP_RAW_POST_DATA'])) {
            throw new PostDataEmptyException();
        }

        $request_xml = $GLOBALS['HTTP_POST_VARS'];
        $request = XmlRequest::object_to_array($request_xml);
        $this->request = array_change_key_case($request, CASE_LOWER);

        switch ($this->getMsgType()) {
            case 'text' :
                $this->onText();
                break;
            case 'image' :
                $this->onImage();
                break;
            case 'voice' :
                $this->ononVoice();
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
                        $this->onEventSubscribe();
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

    abstract public function onText();

    abstract public function onImage();

    abstract public function onVoice();

    abstract public function onVideo();

    abstract public function onLocation();

    abstract public function onLink();

    abstract public function onUnknownMessage();

    abstract public function onEventSubscribe();

    abstract public function onEventUnSubScribe();

    abstract public function onEventScan();

    abstract public function onEventLocation();

    abstract public function onEventClick();

    abstract public function onUnknownEvent();

    /**
     * 获取本次请求中的参数，不区分大小
     *
     * @param bool|string $param 参数名，默认为无参
     * @return mixed
     */
    protected function getRequest($param = FALSE) {
        if ($param === FALSE) {
            return $this->request;
        }
        $param = strtolower($param);
        if (isset($this->request[$param])) {
            return $this->request[$param];
        }
        return NULL;
    }

    protected function getFromUserName(){
        return $this->getRequest('FromUserName');
    }

    protected function getToUserName(){
        return $this->getRequest('ToUserName');
    }

    protected function getCreateTime(){
        return $this->getRequest('CreateTime');
    }

    protected function getMsgType(){
        return $this->getRequest('MsgType');
    }

    protected function getEvent(){
        return $this->getRequest('Event');
    }

    /**
     * 验证消息真实性
     *
     * @param  string $token 验证信息
     * @return boolean
     */
    public function validateSignature($token) {
        if ( ! (isset($_GET['signature']) && isset($_GET['timestamp']) && isset($_GET['nonce']))) {
            return FALSE;
        }

        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        $signatureArray = [$token, $timestamp, $nonce];
        sort($signatureArray,SORT_STRING);
        return sha1(implode($signatureArray)) == $signature;
    }

    /**
     * 修改微信API配置时，微信会发送验证到URL
     * 判断此次请求是否为验证请求
     * 如果是，你需要在上层直接输出原始的echostr并返回
     *
     * @return boolean
     */
    public function isValid() {
        return isset($_GET['echostr']);
    }
}
