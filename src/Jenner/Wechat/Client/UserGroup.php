<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-13
 * Time: 下午2:25
 */

namespace Jenner\Wechat\Client;


use Jenner\Wechat\WechatConfig;

/**
 * 用户分组管理
 * Class UserGroup
 * @package Jenner\Wechat\Client
 */
class UserGroup extends WechatClient
{
    /**
     * 创建分组
     * @param $group
     * @return bool|mixed
     */
    public function create($group)
    {
        $uri = $this->uri_prefix . WechatConfig::USER_GROUP_CREATE;
        return $this->request_post($uri, $group);
    }

    /**
     * 获取分组
     * @return bool|mixed
     */
    public function get()
    {
        $uri = $this->uri_prefix . WechatConfig::USER_GROUP_GET;
        return $this->request_get($uri);
    }

    /**
     * 根据OPEN_ID获取用户所属分组
     * @param $open_id
     * @return bool|mixed
     */
    public function getByOpenId($open_id)
    {
        $uri = $this->uri_prefix . WechatConfig::USER_GROUP_GET_BY_OPEN_ID;
        return $this->request_post($uri, ['openid' => $open_id]);
    }

    /**
     * 更新分组名称
     * @param $group_id
     * @param $name
     * @return bool|mixed
     */
    public function update($group_id, $name)
    {
        $uri = $this->uri_prefix . WechatConfig::USER_GROUP_UPDATE;
        $params = ['group' => ['id' => $group_id, 'name' => $name]];
        return $this->request_post($uri, $params);
    }

    /**
     * 移动用户分组
     * @param $open_id
     * @param $to_group_id
     * @return bool|mixed
     */
    public function userGroupUpdate($open_id, $to_group_id)
    {
        $uri = $this->uri_prefix . WechatConfig::USER_GROUP_MEMBER_UPDATE;
        $params = ['openid' => $open_id, 'to_group_id' => $to_group_id];
        return $this->request_post($uri, $params);
    }
} 