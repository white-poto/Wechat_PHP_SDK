<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-20
 * Time: 上午9:57
 */

namespace Jenner\Zebra\Wechat\Client\MenuStructure;


class ViewButton extends Button
{
    public function __construct($name, $url)
    {
        parent::__construct($name, 'view');
        $this->setUrl($url);
    }
} 