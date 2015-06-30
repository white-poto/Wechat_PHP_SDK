<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-12
 * Time: 上午10:56
 */

namespace Jenner\Wechat\Client\Message;


class Text extends AbstractMessage
{

    /**
     * @param $to_user 普通用户openid
     * @param $text 文本消息内容
     */
    public function __construct($to_user, $text)
    {
        parent::__construct($to_user);

        $this->params['msgtype'] = 'text';
        $this->params['text'] = [];
        $this->params['text']['content'] = $text;
    }
} 