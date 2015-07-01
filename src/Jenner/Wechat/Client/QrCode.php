<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-14
 * Time: 上午11:51
 */

namespace Jenner\Wechat\Client;

use Jenner\Wechat\Exception\WechatException;
use Jenner\Wechat\Tool\Http;

class QrCode extends Client
{

    const API_CREATE    = 'https://api.weixin.qq.com/cgi-bin/qrcode/create';
    const API_DOWNLOAD  = 'https://api.weixin.qq.com/cgi-bin/showqrcode';

    /**
     * 创建永久二维码
     * @param $expire_seconds
     * @param $scene_id
     * @return bool|mixed
     */
    public function create($expire_seconds, $scene_id)
    {
        $params = [
            'expire_seconds' => $expire_seconds,
            'action_name' => 'QR_LIMIT_SCENE',
            'scene' => ['scene_id' => $scene_id]
        ];
        return $this->request_post(self::API_CREATE, $params);
    }

    /**
     * 创建临时二维码
     * @param $expire_seconds
     * @param $scene_id
     * @return bool|mixed
     */
    public function createTemp($expire_seconds, $scene_id)
    {
        $params = [
            'expire_seconds' => $expire_seconds,
            'action_name' => 'QR_SCENE',
            'scene' => ['scene_id' => $scene_id]
        ];
        return $this->request_post(self::API_CREATE, $params);
    }

    /**
     * 下载二维码
     * @param $ticket
     * @return mixed
     * @throws \Jenner\Wechat\Exception\WechatException
     */
    public function download($ticket)
    {
        $ticket = urlencode($ticket);
        $http = new Http(self::API_DOWNLOAD);
        $image = $http->GET(compact('ticket'));
        if ($http->getStatus() != 200) {
            $message = 'download qrcode image failed. the ticket param error';
            throw new WechatException($message);
        }

        return $image;
    }
} 