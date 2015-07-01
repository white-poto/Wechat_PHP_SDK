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
    const API_LIST              = 'https://api.weixin.qq.com/cgi-bin/customservice/getkflist';
    const API_ONLINE_LIST       = 'https://api.weixin.qq.com/cgi-bin/customservice/getonlinekflist';
    const API_ADD               = 'https://api.weixin.qq.com/cgi-bin/customservice/kfaccount/add';
    const API_UPDATE            = 'https://api.weixin.qq.com/cgi-bin/customservice/kfaccount/update';
    const API_DELETE            = 'https://api.weixin.qq.com/cgi-bin/customservice/kfaccount/del';
    const API_UPLOAD_HEAD_IMG   = 'https://api.weixin.qq.com/cgi-bin/customservice/kfacount/uploadheadimg';
    const API_RECORD            = 'https://api.weixin.qq.com/cgi-bin/customservice/getrecord';
    
    /**
     * 获取客服基本信息
     * @return bool|mixed
     */
    public function get()
    {
        return $this->request_get(self::API_LIST);
    }

    /**
     * 获取在线客服接待信息
     * @return bool|mixed
     */
    public function getOnline()
    {
        return $this->request_get(self::API_ONLINE_LIST);
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
        $params = ['account' => $account, 'nickname' => $nickname, 'password' => $password];
        return $this->request_post(self::API_ADD, $params);
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
        $params = ['account' => $account, 'nickname' => $nickname, 'password' => $password];
        return $this->request_post(self::API_UPDATE, $params);
    }

    /**
     * 上传客服头像
     * @param $account
     * @param string $img_with_full_path 图片地址，绝对路径
     * @return bool|mixed
     */
    public function uploadHeadImg($account, $img_with_full_path)
    {
        $get_params = ['kf_account' => $account];
        $post_params = ['media' => '@' . $img_with_full_path];
        return $this->request(self::API_UPLOAD_HEAD_IMG, $post_params, $get_params, true);
    }

    /**
     * 删除客服账号
     * @param $account
     * @return bool|mixed
     */
    public function delete($account)
    {
        $params = ['kf_account' => $account];
        return $this->request_get(self::API_DELETE, $params);
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

        $params = [
            'starttime' => $start_time,
            'endtime' => $end_time,
            'openid' => $open_id,
            'pagesize' => $page_size,
            'pageindex' => $page_index,
        ];

        return $this->request_post(self::API_RECORD, $params);
    }
}
