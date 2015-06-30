<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-12
 * Time: 上午11:08
 */

namespace Jenner\Wechat\Client\Message;


class Video extends AbstractMessage
{
    /**
     * @param $to_user 普通用户openid
     * @param $media_id 发送的视频的媒体ID
     * @param $thumb_media_id 缩略图的媒体ID
     * @param null $title 视频消息的标题
     * @param null $description 视频消息的描述
     */
    public function __construct($to_user, $media_id, $thumb_media_id, $title = null, $description = null)
    {
        parent::__construct($to_user);

        $this->params['msgtype'] = 'video';
        $this->params['video'] = [];
        $this->params['video']['media_id'] = $media_id;
        $this->params['video']['thumb_media_id'] = $thumb_media_id;
        $this->params['video']['title'] = $title;
        $this->params['video']['description'] = $description;

    }
} 