<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-7
 * Time: 上午9:41
 */

namespace Jenner\Zebra\Tools;


/**
 * Class CommonArray
 * @package Jenner\Zebra\Tools
 */
class CommonArray {
    /**
     * 根据列的Key获取一个二维数组中某一列的值，作为一维数组返回
     * @param $column
     * @param $array
     * @return array
     */
    public static function columnValue($column, $array){
        $result = [];
        $array = (array)$array;
        foreach($array as $value){
            $value = (array)$value;
            $result[] = empty($value[$column]) ? null : $value[$column];
        }
        return $result;
    }

    /**
     * 根据field获取对象的属性获作为一个数组返回
     * @param $filed
     * @param $object
     * @return array
     */
    public static function fieldValue($filed, $object){
        $result = [];
        $object = (object)$object;
        foreach($object as $value){
            $result[] = isset($value->$filed) ? false : $value->$filed;
        }
        return $result;
    }

    /**
     * 类似SQL ORDER BY 的多为数组排序函数
     * example: $sorted = array_orderby($data, 'volume', SORT_DESC, 'edition', SORT_ASC);
     *
     * @return mixed
     */
    public static function arrayOrderby()
    {
        $args = \func_get_args();
        $data = \array_shift($args);
        foreach ($args as $n => $field) {
            if (\is_string($field)) {
                $tmp = array();
                foreach ($data as $key => $row)
                    $tmp[$key] = $row[$field];
                $args[$n] = $tmp;
            }
        }
        $args[] = & $data;
        \call_user_func_array('array_multisort', $args);
        return \array_pop($args);
    }

    /**
     * object 转 array
     */
    function objectToArray($obj){
        $_arr = is_object($obj)? get_object_vars($obj) : $obj;
        foreach ($_arr as $key => $val) {
            $val = (is_array($val)) || is_object($val) ? object_to_array($val) : $val;
            $arr[$key] = $val;
        }

        return $arr;
    }
} 