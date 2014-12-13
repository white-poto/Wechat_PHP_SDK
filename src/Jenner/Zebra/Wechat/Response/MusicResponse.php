<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-13
 * Time: 上午11:57
 */

namespace Jenner\Zebra\Wechat\Response;


class MusicResponse extends XmlResponse
{

    public function __construct($to_user, $from_user, $thumb_media_id, $title = null, $description = null, $music_url = null, $hq_music_url = null)
    {
        parent::__construct($to_user, $from_user);
        $this->replace['Title'] = $title;
        $this->replace['Description'] = $description;
        $this->replace['MusicUrl'] = $music_url;
        $this->replace['HQMusicUrl'] = $hq_music_url;
        $this->replace['ThumbMediaId'] = $thumb_media_id;
    }

    protected function initTemplate()
    {
        $this->template = <<<XML
<xml>
<ToUserName><![CDATA[{ToUserName}]]></ToUserName>
<FromUserName><![CDATA[{FromUserName}]]></FromUserName>
<CreateTime>{CreateTime}</CreateTime>
<MsgType><![CDATA[music]]></MsgType>
<Music>
<Title><![CDATA[{Title}]]></Title>
<Description><![CDATA[{Description}]]></Description>
<MusicUrl><![CDATA[{MusicUrl}]]></MusicUrl>
<HQMusicUrl><![CDATA[{HQMusicUrl}]]></HQMusicUrl>
<ThumbMediaId><![CDATA[{ThumbMediaId}]]></ThumbMediaId>
</Music>
</xml>
XML;

    }
}