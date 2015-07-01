<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-13
 * Time: 下午1:34
 */

namespace Jenner\Wechat\Client;

use Jenner\Wechat\Config\URI;

class Menu extends Client
{
    /**
     * 获取微信菜单
     * @return bool|mixed
     */
    public function get()
    {
        $uri = $this->uri_prefix . URI::MENU_GET;
        return $this->request_get($uri);
    }

    /**
     * 删除微信菜单
     * @return bool|mixed
     */
    public function delete()
    {
        $uri = $this->uri_prefix . URI::MENU_DELETE;
        return $this->request_get($uri);
    }

    /**
     * 创建微信菜单，格式如：
     * {"button":[
     * {"type":"click","name":"今日歌曲","key":"V1001_TODAY_MUSIC"},
     * {"name":"菜单","sub_button":[{"type":"view","name":"搜索","url":"http:\/\/www.soso.com\/"},
     * {"type":"view","name":"视频","url":"http:\/\/v.qq.com\/"},
     * {"type":"click","name":"赞一下我们","key":"V1001_GOOD"}]}
     * ]}
     * @param $menu
     * @return bool|mixed
     */
    public function create($menu)
    {
        $uri = $this->uri_prefix . URI::MENU_CREATE;
        return $this->request_post($uri, $menu);
    }
}