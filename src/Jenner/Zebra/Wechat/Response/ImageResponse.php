<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-13
 * Time: 下午1:46
 */

namespace Jenner\Zebra\Wechat\Response;


class ImageResponse extends XmlResponse
{

    public function __construct($to_user, $from_user, $media_id)
    {
        parent::__construct($to_user, $from_user);
        $this->replace['MediaId'] = $media_id;
    }

    protected function initTemplate()
    {
        $this->template = <<<XML
<xml>
<ToUserName><![CDATA[{ToUserName}]]></ToUserName>
<FromUserName><![CDATA[{FromUserName}]]></FromUserName>
<CreateTime>{CreateTime}</CreateTime>
<MsgType><![CDATA[image]]></MsgType>
<Image>
<MediaId><![CDATA[{MediaId}]]></MediaId>
</Image>
</xml>
XML;
    }
}


