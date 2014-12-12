<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-14
 * Time: 上午11:27
 *
 * 发送客服消息基类
 */

namespace Jenner\Zebra\Wechat\Client\Message;

use Jenner\Zebra\Wechat\Client\WechatClient;
use Jenner\Zebra\Wechat\WechatUri;


/**
 * Class CustomMessage
 * @package vendor\wechat\client
 */
abstract class BaseCustomMessage extends WechatClient
{

    /**
     * 客服消息API地址
     */
    protected $uri;

    /**
     * 消息体
     */
    protected $params;

    /**
     * @param $to_user
     */
    public function __construct($to_user)
    {
        parent::__construct();
        $this->params['touser'] = $to_user;
        $this->uri = $this->uri_prefix . WechatUri::MESSAGE_SEND;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function send(BaseCustomMessage $message)
    {
        $params = $message->getMessage();
        return $this->request($this->uri, $params);
    }
} 