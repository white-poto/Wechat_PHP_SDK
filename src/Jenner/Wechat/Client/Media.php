<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-19
 * Time: 下午1:36
 */

namespace Jenner\Wechat\Client;


use Jenner\Wechat\Exception\WechatException;
use Jenner\Wechat\Config\URI;

class Media extends Client
{

    const API_UPLOAD = 'https://api.weixin.qq.com/cgi-bin/media/upload';

    public function upload($type, $absolute_file)
    {
        if (!file_exists($absolute_file) || !is_readable($absolute_file)){
            $message = 'file does not exists or file cannot be read.filename:' . $absolute_file;
            throw new WechatException($message);
        }

        $get_params = compact('type');
        $post_params = ['media' => '@' . $absolute_file];
        return $this->request(self::API_UPLOAD, $post_params, $get_params, true);
    }

    public function uploadImage($absolute_file)
    {

    }
} 