<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-20
 * Time: 上午9:59
 */

namespace Jenner\Zebra\Wechat\Client\MenuStructure;


class EventButton extends Button
{
    public function __construct($name, $type, $key)
    {
        parent::__construct($name, $type);
        $this->setKey($key);
    }
} 