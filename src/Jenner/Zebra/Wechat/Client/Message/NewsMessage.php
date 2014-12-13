<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-12
 * Time: 上午11:13
 */

namespace Jenner\Zebra\Wechat\Client\Message;


class NewsMessage extends BaseCustomMessage
{
    /**
     * @param $to_user 普通用户openid
     * @param NewsMessageItem[] $news_items
     */
    public function __construct($to_user, $news_items)
    {
        parent::__construct($to_user);

        $this->params['msgtype'] = 'news';
        $this->params['news'] = [];
        $this->params['news']['articles'] = [];
        foreach ($news_items as $item) {
            $this->params['news']['articles'][] = $item->getParams();
        }
    }
} 