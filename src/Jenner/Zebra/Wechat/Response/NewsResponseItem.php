<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-12
 * Time: 上午10:44
 */

namespace Jenner\Zebra\Wechat\Response;


class NewsResponseItem extends XmlResponse
{
    public function __construct($to_user, $from_user, $title = null, $description = null, $pic_url = null, $url = null)
    {
        parent::__construct($to_user, $from_user);
        $this->replace['Title'] = $title;
        $this->replace['Description'] = $description;
        $this->replace['PicUrl'] = $pic_url;
        $this->replace['Url'] = $url;
    }

    /**
     * @return mixed
     */
    protected function initTemplate()
    {
        $this->item_template = <<<XML
<item>
<Title><![CDATA[{Title}]]></Title>
<Description><![CDATA[{Description}]]></Description>
<PicUrl><![CDATA[{PicUrl}]]></PicUrl>
<Url><![CDATA[{Url}]]></Url>
</item>
XML;

    }
}