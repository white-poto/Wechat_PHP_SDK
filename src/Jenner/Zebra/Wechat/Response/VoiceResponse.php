<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-13
 * Time: 下午1:54
 */

namespace Jenner\Zebra\Wechat\Response;


class VoiceResponse extends XmlResponse {
    protected function initTemplate(){
        $this->template = <<<XML
<xml>
<ToUserName><![CDATA[{ToUserName}]]></ToUserName>
<FromUserName><![CDATA[{FromUserName}]]></FromUserName>
<CreateTime>{CreateTime}</CreateTime>
<MsgType><![CDATA[voice]]></MsgType>
<Voice>
<MediaId><![CDATA[{MediaId}]]></MediaId>
</Voice>
</xml>
XML;
    }
}