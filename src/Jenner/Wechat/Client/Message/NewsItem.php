<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-12
 * Time: 上午11:14
 */

namespace Jenner\Wechat\Client\Message;


class NewsItem extends AbstractMessage
{
    /**
     * @param $title 标题
     * @param $description 描述
     * @param $url 点击后跳转的链接
     * @param $pic_url 图文消息的图片链接，支持JPG、PNG格式，较好的效果为大图640*320，小图80*80
     */
    public function __construct($title, $description, $url, $pic_url)
    {
        $this->params['title'] = $title;
        $this->params['description'] = $description;
        $this->params['url'] = $url;
        $this->params['picurl'] = $pic_url;
    }
}