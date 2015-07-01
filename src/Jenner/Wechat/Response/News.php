<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-13
 * Time: 下午12:15
 */

namespace Jenner\Wechat\Response;


/**
 * 用于回复的图文消息类型
 */
class News extends AbstractXml
{

    protected $items;

    public function __construct($to_user, $from_user, $items)
    {
        parent::__construct($to_user, $from_user);
        $this->items = $items;
    }

    public function create()
    {
        $response = $this->create();
        $item_response = '';
        foreach ($this->items as $item) {
            $item_response .= $item->create();
        }
        $response = str_replace('{item}', $item_response, $response);

        return $response;
    }

    protected function initTemplate()
    {
        $this->template = <<<XML
<xml>
<ToUserName><![CDATA[{ToUserName}]]></ToUserName>
<FromUserName><![CDATA[{FromUserName}]]></FromUserName>
<CreateTime>{CreateTime}</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>{ArticleCount}</ArticleCount>
<Articles>
{item}
</Articles>
</xml>
XML;
    }
}