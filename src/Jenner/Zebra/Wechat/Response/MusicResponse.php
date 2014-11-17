<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-13
 * Time: 上午11:57
 */

namespace Jenner\Zebra\Wechat\Response;


class MusicResponse extends XmlResponse {

    public function create($content)
    {

    }

    protected function initTemplate(){
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