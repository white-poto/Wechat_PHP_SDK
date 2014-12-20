<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-13
 * Time: 下午4:06
 * 微信XML请求转换成PHP数组
 */

namespace Jenner\Zebra\Wechat\Request;


class XmlRequest
{

    public static function toArray($xml)
    {
        $obj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        return self::object_to_array($obj);
    }

    public static function object_to_array($obj)
    {
        $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
        foreach ($_arr as $key => $val) {
            $val = (is_array($val)) || is_object($val) ? self::object_to_array($val) : $val;
            $arr[$key] = $val;
        }

        return $_arr;
    }
}