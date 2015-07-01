<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-13
 * Time: 下午2:45
 */

namespace Jenner\Wechat\Client;

use Jenner\Wechat\Exception\WechatException;
use Jenner\Wechat\Config\URI;

/**
 * 客服管理
 * Class CustomService
 * @package Jenner\Wechat\Client
 */
class CustomService extends Client
{
    const API_SERVICE_LIST          = 'https://api.weixin.qq.com/cgi-bin/customservice/getkflist';
    const API_SERVICE_ONLINE_LIST   = 'https://api.weixin.qq.com/cgi-bin/customservice/getonlinekflist';
    /**
     * 获取客服基本信息
     * @return bool|mixed
     */
    public function get()
    {
        return $this->request_get(self::API_SERVICE_LIST);
    }

    /**
     * 获取在线客服接待信息
     * @return bool|mixed
     */
    public function getOnline()
    {
        return $this->request_get(self::API_SERVICE_ONLINE_LIST);
    }

    /**
     * 添加客服账号
     * @param $account
     * @param $nickname
     * @param $password
     * @return bool|mixed
     */
    public function add($account, $nickname, $password)
    {
        $uri = $this->uri_prefix . URI::CUSTOM_SERVICE_ADD;
        $params = ['account' => $account, 'nickname' => $nickname, 'password' => $password];
        return $this->request_post($uri, $params);
    }

    /**
     * 设置客服信息
     * @param $account
     * @param $nickname
     * @param $password
     * @return bool|mixed
     */
    public function update($account, $nickname, $password)
    {
        $uri = $this->uri_prefix . URI::CUSTOM_SERVICE_UPDATE;
        $params = ['account' => $account, 'nickname' => $nickname, 'password' => $password];
        return $this->request_post($uri, $params);
    }

    /**
     * 上传客服头像
     * @param $account
     * @param $img_with_full_path 图片地址，绝对路径
     * @return bool|mixed
     */
    public function uploadHeadImg($account, $img_with_full_path)
    {
        $uri = $this->uri_prefix . URI::CUSTOM_SERVICE_UPLOAD_HEAD_IMG;
        $get_params = ['kf_account' => $account];
        $post_params = ['media' => '@' . $img_with_full_path];
        return $this->request($uri, $post_params, $get_params, true);
    }

    /**
     * 删除客服账号
     * @param $account
     * @return bool|mixed
     */
    public function delete($account)
    {
        $uri = $this->uri_prefix . URI::CUSTOM_SERVICE_DELETE;
        $params = ['kf_account' => $account];
        return $this->request_get($uri, $params);
    }

    /**
     * 获取客服聊天记录
     * @param $start_time 查询开始时间，UNIX时间戳
     * @param $end_time 查询结束时间，UNIX时间戳，每次查询不能跨日查询
     * @param $open_id 普通用户的标识，对当前公众号唯一
     * @param $page_size 每页大小，每页最多拉取1000条
     * @param $page_index 查询第几页，从1开始
     * @throws \Jenner\Wechat\Exception\WechatException
     * @return bool|mixed
     */
    public function getRecord($start_time, $end_time, $open_id, $page_size, $page_index)
    {
        if ($page_size > 1000) {
            throw new WechatException('page_size out of range');
        }

        $start_date = date('Y-m-d', $start_time);
        $end_date = date('Y-m-d', $end_time);
        if ($start_date != $end_date) {
            throw new WechatException('param start_time and end_time cannot span multiple days');
        }

        $uri = $this->uri_prefix . URI::CUSTOM_SERVICE_RECORD;
        $params = [
            'starttime' => $start_time,
            'endtime' => $end_time,
            'openid' => $open_id,
            'pagesize' => $page_size,
            'pageindex' => $page_index,
        ];

        return $this->request_post($uri, $params);
    }
}
