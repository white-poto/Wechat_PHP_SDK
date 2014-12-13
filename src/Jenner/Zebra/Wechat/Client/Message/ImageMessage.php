<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-12
 * Time: 上午11:04
 */

namespace Jenner\Zebra\Wechat\Client\Message;


class ImageMessage extends BaseCustomMessage
{

    /**
     * @param $to_user 普通用户openid
     * @param $media_id 媒体ID
     */
    public function __construct($to_user, $media_id)
    {
        parent::__construct($to_user);

        $this->params['msgtype'] = 'image';
        $this->params['image'] = [];
        $this->params['image']['media_id'] = $media_id;
    }
} 