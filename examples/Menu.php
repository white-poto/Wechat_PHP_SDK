<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-20
 * Time: 下午4:43
 */


$menu = array (
    1 =>
        array (
            'name' => '功能列表',
            'type' => NULL,
            'url' => '',
            'key' => '1',
            'sub_button' =>
                array (
                    0 =>
                        array (
                            'id' => 6,
                            'shop_id' => 1,
                            'type' => 'view',
                            'name' => '百度',
                            'key' => '1',
                            'url' => 'http://www.baidu.com',
                            'pid' => 1,
                            'rank' => 0,
                            'created_at' => '2014-12-19 16:57:04',
                            'updated_at' => '2014-12-19 16:57:04',
                            'text' => '',
                        ),
                    1 =>
                        array (
                            'id' => 7,
                            'shop_id' => 1,
                            'type' => 'click',
                            'name' => '测试',
                            'key' => '1',
                            'url' => '',
                            'pid' => 1,
                            'rank' => 1,
                            'created_at' => '2014-12-19 16:57:42',
                            'updated_at' => '2014-12-19 16:57:42',
                            'text' => 'dddd',
                        ),
                ),
        ),
);

$button = \Jenner\Zebra\Wechat\Client\MenuStructure\Factory::create($layered_menus);


define('WECHAT_APP_ID', 'your wechat app_id');
define('WECHAT_SECRET', 'your wechat secret');

$menu = new \Jenner\Zebra\Wechat\Client\Menu();
$menu->create($button);