<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-20
 * Time: 上午10:14
 */

namespace Jenner\Zebra\Wechat\Client\MenuStructure;


use Jenner\Zebra\Wechat\Exception\WechatException;

class Factory
{
    /**
     * 菜单快捷创建，需要传入的参数与微信接口参数一致
     * 但不需要最外围的button
     * @param $layered_buttons
     * @return array
     */
    public static function create($layered_buttons)
    {
        $button_menu = new ButtonMenu();

        foreach ($layered_buttons as $layered_button) {
            $button = self::CreateButton($layered_button);
            if (!empty($layered_button['sub_button'])) {
                foreach ($layered_button['sub_button'] as $sub_button) {
                    $sub_button_obj = self::CreateButton($sub_button);
                    $button->addSubButton($sub_button_obj);
                }
            }
            $button_menu->addButton($button);
        }

        return $button_menu->create();
    }

    protected static function CreateButton($menu)
    {
        // 父级按钮创建
        if (empty($menu['type'])) {
            return new Button($menu['name']);
        }

        //点击事件类型推送按钮创建
        if ($menu['type'] == 'click') {
            if (empty($menu['key']))
                throw new WechatException('button key cannot be empty');
            return new ClickButton($menu['name'], $menu['key']);
        } //跳转页面类型按钮创建
        elseif ($menu['type'] == 'view') {
            if (empty($menu['url']))
                throw new WechatException('button url cannot be empty');
            return new ViewButton($menu['name'], $menu['url']);
        } //事件类型按钮创建
        else {
            if (empty($menu['key']))
                throw new WechatException('button key cannot be empty');
            return new EventButton($menu['name'], $menu['type'], $menu['key']);
        }
    }
} 