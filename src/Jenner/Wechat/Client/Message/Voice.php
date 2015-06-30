<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-12
 * Time: 上午11:06
 */

namespace Jenner\Wechat\Client\Message;


class Voice extends AbstractMessage
{
    /**
     * @param $to_user 普通用户openid
     * @param $media_id 发送的语音的媒体ID
     */
    public function __construct($to_user, $media_id)
    {
        parent::__construct($to_user);

        $this->params['msgtype'] = 'voice';
        $this->params['voice'] = [];
        $this->params['voice']['content'] = $media_id;
    }
} 