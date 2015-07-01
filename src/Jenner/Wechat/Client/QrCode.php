<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-14
 * Time: 上午11:51
 */

namespace Jenner\Wechat\Client;

use Jenner\Wechat\Exception\WechatException;
use Jenner\Wechat\Config\URI;
use Jenner\Wechat\Tool\Http;

class QrCode extends Client
{

    /**
     * 创建永久二维码
     * @param $expire_seconds
     * @param $scene_id
     * @return bool|mixed
     */
    public function create($expire_seconds, $scene_id)
    {
        $uri = $this->uri_prefix . URI::QR_CODE_CREATE;
        $params = [
            'expire_seconds' => $expire_seconds,
            'action_name' => 'QR_LIMIT_SCENE',
            'scene' => ['scene_id' => $scene_id]
        ];
        return $this->request_post($uri, $params);
    }

    /**
     * 创建临时二维码
     * @param $expire_seconds
     * @param $scene_id
     * @return bool|mixed
     */
    public function createTemp($expire_seconds, $scene_id)
    {
        $uri = $this->uri_prefix . URI::QR_CODE_CREATE;
        $params = [
            'expire_seconds' => $expire_seconds,
            'action_name' => 'QR_SCENE',
            'scene' => ['scene_id' => $scene_id]
        ];
        return $this->request_post($uri, $params);
    }

    /**
     * 下载二维码
     * @param $ticket
     * @return mixed
     * @throws \Jenner\Wechat\Exception\WechatException
     */
    public function download($ticket)
    {
        $uri = $this->uri_prefix . URI::QR_CODE_DOWNLOAD;
        $ticket = urlencode($ticket);
        $http = new Http($uri);
        $image = $http->GET(compact('ticket'));
        if ($http->getStatus() != 200) {
            throw new WechatException('download qrcode image failed. the ticket param error');
        }

        return $image;
    }
} 