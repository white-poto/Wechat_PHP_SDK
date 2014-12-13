<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-13
 * Time: 上午11:39
 */

namespace Jenner\Zebra\Wechat\Response;


class TextResponse extends XmlResponse
{
    public function __construct($to_user, $from_user, $content)
    {
        parent::__construct($to_user, $from_user);
        $this->replace['Content'] = $content;
    }

    protected function initTemplate()
    {
        $this->template = <<<XML
<xml>
<ToUserName><![CDATA[{ToUserName}]]></ToUserName>
<FromUserName><![CDATA[{FromUserName}]]></FromUserName>
<CreateTime>{CreateTime}</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[{Content}]]></Content>
</xml>
XML;
    }
}