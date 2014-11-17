<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-14
 * Time: 下午1:38
 */

namespace Jenner\Zebra\Wechat\Client;


class User extends WechatClient {
    /**
     * 更新用户备注
     * @param $openid
     * @param $remark
     * @return bool|mixed
     */
    public function updateRemark($openid, $remark){
        $uri = $this->uri_config['user']['update_remark'];
        $params = ['openid'=>$openid, 'remark'=>$remark];
        return $this->request_get($uri, $params);
    }

    /**
     * 获取用户基本信息
     * @param $openid
     * @param string $lang
     * @return bool|mixed
     */
    public function info($openid, $lang='zh_CN'){
        $uri = $this->uri_config['user']['info'];
        $params = ['openid'=>$openid, 'lang'=>$lang];
        return $this->request_get($uri, $params);
    }

    /**
     * 获取全部关注列表的OPEN_ID
     * @return mixed
     */
    public function getAll(){
        $uri = $this->uri_config['user']['get'];
        $data = $openid_list = [];
        while(true){
            if($data){
                $data = $this->request_get($uri, ['next_openid'=>$data['next_openid']]);
            }else{
                $data = $this->request_get($uri);
            }
            $openid_list = array_merge($openid_list, $data['data']['openid']);
            if(empty($data['next_openid'])){
                break;
            }
        }
        $result['count'] = count($openid_list);
        $result['total'] = $data['total'];

        return $result;
    }
} 