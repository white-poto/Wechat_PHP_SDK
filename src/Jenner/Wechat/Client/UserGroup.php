<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-13
 * Time: 下午2:25
 */

namespace Jenner\Wechat\Client;

use Jenner\Wechat\Config\URI;

/**
 * 用户分组管理
 * Class UserGroup
 * @package Jenner\Wechat\Client
 */
class UserGroup extends Client
{
    const API_CREATE        = 'https://api.weixin.qq.com/cgi-bin/groups/create';
    const API_GET           = 'https://api.weixin.qq.com/cgi-bin/groups/get';
    const API_GET_ID        = 'https://api.weixin.qq.com/cgi-bin/groups/getid';
    const API_UPDATE        = 'https://api.weixin.qq.com/cgi-bin/groups/update';
    const API_MEMBER_UPDATE = 'https://api.weixin.qq.com/cgi-bin/groups/members/update';
    /**
     * 创建分组
     * @param $group
     * @return bool|mixed
     */
    public function create($group)
    {
        return $this->request_post(self::API_CREATE, $group);
    }

    /**
     * 获取分组
     * @return bool|mixed
     */
    public function get()
    {
        return $this->request_get(self::API_GET);
    }

    /**
     * 根据OPEN_ID获取用户所属分组
     * @param $open_id
     * @return bool|mixed
     */
    public function getByOpenId($open_id)
    {
        return $this->request_post(self::API_GET_ID, ['openid' => $open_id]);
    }

    /**
     * 更新分组名称
     * @param $group_id
     * @param $name
     * @return bool|mixed
     */
    public function update($group_id, $name)
    {
        $params = ['group' => ['id' => $group_id, 'name' => $name]];
        return $this->request_post(self::API_UPDATE, $params);
    }

    /**
     * 移动用户分组
     * @param $open_id
     * @param $to_group_id
     * @return bool|mixed
     */
    public function userGroupUpdate($open_id, $to_group_id)
    {
        $params = ['openid' => $open_id, 'to_group_id' => $to_group_id];
        return $this->request_post(self::API_MEMBER_UPDATE, $params);
    }
} 