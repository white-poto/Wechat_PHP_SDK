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
    
    const API_GET      = 'https://api.weixin.qq.com/cgi-bin/menu/get';
    const API_DELETE   = 'https://api.weixin.qq.com/cgi-bin/menu/delete';
    const API_CREATE   = 'https://api.weixin.qq.com/cgi-bin/menu/create';
    
    /**
     * 获取微信菜单
     * @return bool|mixed
     */
    public function get()
    {
        return $this->request_get(self::API_GET);
    }

    /**
     * 删除微信菜单
     * @return bool|mixed
     */
    public function delete()
    {
        return $this->request_get(self::API_DELETE);
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
        return $this->request_post(self::API_CREATE, $menu);
    }
}