<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-14
 * Time: 上午11:27
 */

namespace Jenner\Zebra\Wechat\Client;
use Jenner\Zebra\Wechat\C;

/**
 * Class CustomMessage
 * @package vendor\wechat\client
 */
class CustomMessage extends WechatClient {

    /**
     * @var
     */
    protected $touser;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @param $to_user
     */
    public function __construct($to_user=null){
        parent::__construct();
        $this->touser = $to_user;
        $this->uri = $this->uri_prefix . C::get('uri.message.custom_send');
    }

    /**
     * 发送文本消息
     * @param $text "content":"Hello World"
     * @param null $to_user
     * @internal param null $to_user
     * @return bool|mixed
     */
    public function sendText($text, $to_user=null){
        return $this->sendMessage('text', $text, $to_user);
    }

    /**
     * 发送图片消息
     * @param $image "media_id":"MEDIA_ID"
     * @param null $to_user
     * @return bool|mixed
     */
    public function sendImage($image, $to_user=null){
        return $this->sendMessage('image', $image, $to_user);
    }

    /**
     * 发送语音消息
     * @param $voice "media_id":"MEDIA_ID"
     * @param null $to_user
     * @return bool|mixed
     */
    public function sendVoice($voice, $to_user=null){
        return $this->sendMessage('voice', $voice, $to_user);
    }

    /**
     * 发送视频消息
     * @param $video
     *  "media_id":"MEDIA_ID",
     * "thumb_media_id":"MEDIA_ID",
     * "title":"TITLE",
     * "description":"DESCRIPTION"
     * @param null $to_user
     * @return bool|mixed
     */
    public function sendVideo($video, $to_user=null){
        return $this->sendMessage('video', $video, $to_user);
    }

    /**
     * 发送音乐消息
     * @param $music
     * "title":"MUSIC_TITLE",
     * "description":"MUSIC_DESCRIPTION",
     * "musicurl":"MUSIC_URL",
     * "hqmusicurl":"HQ_MUSIC_URL",
     * "thumb_media_id":"THUMB_MEDIA_ID"
     * @param null $to_user
     * @return bool|mixed
     */
    public function sendMusic($music, $to_user=null){
        return $this->sendMessage('music', $music, $to_user);
    }

    /**
     * 发送图文消息
     * @param $news
     * "articles": [
     * {
     * "title":"Happy Day",
     * "description":"Is Really A Happy Day",
     * "url":"URL",
     * "picurl":"PIC_URL"
     * },
     * {
     * "title":"Happy Day",
     * "description":"Is Really A Happy Day",
     * "url":"URL",
     * "picurl":"PIC_URL"
     * }
     * @param null $to_user
     * @return bool|mixed
     */
    public function sendNews($news, $to_user=null){
        return $this->sendMessage('news', $news, $to_user);
    }

    /**
     * @param $message_type
     * @param $message
     * @param null $to_user
     * @return bool|mixed
     */
    private function sendMessage($message_type, $message, $to_user=null){
        if(!is_null($to_user)){
            $params['touser'] = $to_user;
        }else{
            $params['touser'] = $this->touser;
        }
        if(empty($params['touser'])) {
            $this->error_code = '-10000';
            $this->error_message = 'touser can not be empty';
            return false;
        }
        $params['msgtype'] = $message_type;
        $params[$message_type] = $message;
        $result = $this->request($this->uri, $params);
        return $result;
    }
} 