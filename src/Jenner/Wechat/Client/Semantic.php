<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-12-14
 * Time: 上午11:43
 */

namespace Jenner\Wechat\Client;

class Semantic extends Client
{
    public function search($uid, $category, $query, $protocol_param)
    {
        $params = [
            'appid' => WECHAT_APP_ID,
            'uid' => $uid,
            'category' => $category,

        ];
    }
} 