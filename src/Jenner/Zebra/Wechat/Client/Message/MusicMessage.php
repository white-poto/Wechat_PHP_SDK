<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-12
 * Time: 上午11:10
 */

namespace Jenner\Zebra\Wechat\Client\Message;


class MusicMessage extends BaseCustomMessage
{
    /**
     * @param $to_user 普通用户openid
     * @param $music_url 音乐链接
     * @param $hq_music_url 高品质音乐链接，wifi环境优先使用该链接播放音乐
     * @param $thumb_media_id 缩略图的媒体ID
     * @param null $title 音乐标题
     * @param null $description 音乐描述
     */
    public function __construct($to_user, $music_url, $hq_music_url, $thumb_media_id, $title = null, $description = null)
    {
        parent::__construct($to_user);

        $this->params['msgtype'] = 'music';
        $this->params['music'] = [];
        $this->params['music']['title'] = $title;
        $this->params['music']['description'] = $description;
        $this->params['music']['musicurl'] = $music_url;
        $this->params['music']['hqmusicurl'] = $hq_music_url;
        $this->params['music']['thumb_media_id'] = $thumb_media_id;
    }
} 