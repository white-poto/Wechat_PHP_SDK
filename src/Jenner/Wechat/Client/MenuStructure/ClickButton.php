<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-20
 * Time: 上午9:56
 */

namespace Jenner\Wechat\Client\MenuStructure;


class ClickButton extends Button
{
    public function __construct($name, $key)
    {
        parent::__construct($name, 'click');
        $this->setKey($key);
    }
} 