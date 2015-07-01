<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-14
 * Time: 下午1:38
 */

namespace Jenner\Wechat\Client;

use Jenner\Wechat\Config\URI;

class User extends Client
{

    /**
     * 更新用户备注
     * @param $openid
     * @param $remark
     * @return bool|mixed
     */
    public function updateRemark($openid, $remark)
    {
        $uri = $this->uri_prefix . URI::USER_UPDATE_REMARK;
        $params = ['openid' => $openid, 'remark' => $remark];
        $result = $this->request_get($uri, $params);

        return $result;
    }

    /**
     * 获取用户基本信息
     * @param $openid
     * @param string $lang
     * @return bool|mixed
     */
    public function info($openid, $lang = 'zh_CN')
    {
        $uri = $this->uri_prefix . URI::USER_INFO;
        $params = ['openid' => $openid, 'lang' => $lang];
        $response = $this->request_get($uri, $params);

        return $response;
    }

    /**
     * 获取全部关注列表的OPEN_ID
     * @return mixed
     */
    public function getAll()
    {
        $uri = $this->uri_prefix . URI::USER_GET;
        $data = $openid_list = [];
        while (true) {
            if ($data) {
                $data = $this->request_get($uri, ['next_openid' => $data['next_openid']]);
            } else {
                $data = $this->request_get($uri);
            }
            $openid_list = array_merge($openid_list, $data['data']['openid']);
            if (empty($data['next_openid'])) {
                break;
            }
        }
        $result['count'] = count($openid_list);
        $result['total'] = $data['total'];

        return $result;
    }
}

