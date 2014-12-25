<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-15
 * Time: 上午11:14
 */

namespace Jenner\Zebra\Wechat\Client\Merchant;


use Jenner\Zebra\Wechat\WechatUri;

class Common extends BaseMerchant {
    public function uploadImage($filename_with_full_path){
        $uri = $this->merchant_uri_prefix . WechatUri::MERCHANT_COMMON_UPLOAD_IMG;
        $file_name = basename($filename_with_full_path);
        return $this->request($uri, ['filename'=>$file_name], file_get_contents($filename_with_full_path), true);
    }
} 