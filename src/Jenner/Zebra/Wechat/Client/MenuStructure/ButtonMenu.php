<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-20
 * Time: 上午10:03
 */

namespace Jenner\Zebra\Wechat\Client\MenuStructure;


use Jenner\Zebra\Wechat\Exception\WechatException;

class ButtonMenu
{
    protected $buttons;

    public function addButton(Button $button)
    {
        $this->buttons[] = $button->getButton();
    }

    public function create()
    {
        if (count($this->buttons) > 3 || count($this->buttons) < 1) {
            throw new WechatException('Illegal button size');
        }
        foreach ($this->buttons as $button) {
            if (strlen($button['name']) > 16)
                throw new WechatException('Illegal button name size');
        }
        return ['button' => $this->buttons];
    }
} 