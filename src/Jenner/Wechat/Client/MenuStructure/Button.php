<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-20
 * Time: 上午9:48
 */

namespace Jenner\Wechat\Client\MenuStructure;


use Jenner\Wechat\Exception\WechatException;

class Button
{
    protected $button;

    /**
     * @param $name 菜单名称
     * @param null $type 菜单类型
     * @throws \Jenner\Wechat\Exception\WechatException
     */
    public function __construct($name, $type = null)
    {
        if (strlen($name) > 40)
            throw new WechatException('Illegal name size');

        $this->button['name'] = $name;
        if (!in_array($type, ['click', 'view', 'scancode_push', 'scancode_waitmsg', 'pic_sysphoto', 'pic_photo_or_album', 'pic_weixin', 'location_select']) && !is_null($type))
            throw new WechatException('button type error');

        if (!is_null($type)) {
            $this->button['type'] = $type;
        }
    }

    /**
     * @param $key
     * @throws \Jenner\Wechat\Exception\WechatException
     */
    public function setKey($key)
    {
        if (empty($key)) {
            throw new WechatException('Illegal empty button key');
        }
        if (strlen($key) > 128) {
            throw new WechatException('Illegal button key size');
        }

        $this->button['key'] = $key;
    }

    /**
     * @param $url
     * @throws \Jenner\Wechat\Exception\WechatException
     */
    public function setUrl($url)
    {
        if (empty($url)) {
            throw new WechatException('Illegal empty button url');
        }
        if (strlen($url) > 256) {
            throw new WechatException('Illegal button key url');
        }

        $this->button['url'] = $url;
    }

    /**
     * @param Button $button
     * @throws \Jenner\Wechat\Exception\WechatException
     */
    public function addSubButton(Button $button)
    {
        if (!isset($this->button['sub_button']))
            $this->button['sub_button'] = [];

        if (count($this->button) == 5) {
            throw new WechatException('too many sub buttons');
        }

        $this->button['sub_button'][] = $button->getButton();
    }

    public function getButton()
    {
        return $this->button;
    }
}