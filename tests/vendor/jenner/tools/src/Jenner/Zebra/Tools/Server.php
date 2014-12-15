<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-17
 * Time: 下午2:15
 */

namespace Jenner\Zebra\Tools;


class Server {
    /**
     * 获取客户端真实IP
     *
     * @param int $type
     * @return string
     */
    protected static function getIp($type = 0)
    {
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) $cip = $_SERVER["HTTP_CLIENT_IP"];
        else if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        else if (!empty($_SERVER["REMOTE_ADDR"])) $cip = $_SERVER["REMOTE_ADDR"];
        else $cip = "";
        \preg_match("/[\d\.]{7,15}/", $cip, $cips);
        $cip = $cips[0] ? $cips[0] : 'unknown';
        unset($cips);
        if ($type == 1) $cip = \myip2long($cip);
        return $cip;
    }
} 