<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-19
 * Time: 下午1:36
 */

namespace Jenner\Zebra\Wechat\Client;


use Jenner\Zebra\Wechat\Exception\WechatException;
use Jenner\Zebra\Wechat\WechatUri;

class Media extends WechatClient
{
    public function upload($type, $filename_with_full_path)
    {
        if (!file_exists($filename_with_full_path) || !is_readable($filename_with_full_path))
            throw new WechatException('file does not exists or file cannot be read.filename:' . $filename_with_full_path);

        $uri = $this->uri_prefix . WechatUri::MEDIA_UPLOAD;
        $get_params = compact('type');
        $post_params = ['media' => '@' . $filename_with_full_path];
        return $this->request($uri, $post_params, $get_params, true);
    }

    public function uploadImage($filename_with_full_path)
    {

    }
} 