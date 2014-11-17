<?php
/**
 * Created by PhpStorm.
 * User: huyanping
 * Date: 14-9-22
 * Time: 下午5:02
 *
 * 配置文件类
 * C::get('key');
 * C::get('key', 'config2');
 * C::get('key', 'field', 'config2');
 */

namespace Jenner\Zebra\Wechat;

class C {

    protected static $config;

    protected static $config_path;

    public static function setConfigPath($callback){
        self::$config_path = call_user_func($callback);
    }

    /**
     * 根据配置文件名称、配置key，获取配置值
     * @param $key
     * @return bool
     */
    public static function get($key){
        self::initConfig($key);
        $keyInfo = explode('.', $key);
        $configFile = $keyInfo[0];
        $realKey = $keyInfo[1];

        if(isset($keyInfo[2]) && !empty($keyInfo[2])){
            $fieldName = $keyInfo[2];
            return self::$config[$configFile][$realKey][$fieldName];
        }else{
            return self::$config[$configFile][$realKey];
        }

        return false;
    }

    /**
     * 根据配置文件名称，配置key，设置配置值，不提供持久化，程序退出后即失效
     * @param $key
     * @param $value
     * @throws \Exception
     */
    public static function set($key, $value){
        if(!\strstr($key, '.')) throw new \Exception('param key does not contain "."');
        $keyInfo = explode('.', $key);
        $configFile = $keyInfo[0];
        $realKey = $keyInfo[1];

        if(isset($keyInfo[2]) && !empty($keyInfo[2])){
            $fieldName = $keyInfo[2];
            self::$config[$configFile][$realKey][$fieldName] = $value;
        }else{
            self::$config[$configFile][$realKey] = $value;
        }
    }

    /**
     * 单例模式初始化配置文件
     * @param string $key
     * @throws \Exception
     */
    private static function initConfig($key){
        if(!isset(self::$config_path) || empty(self::$config_path)){
            self::$config_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Config';
        }

        if(!\strstr($key, '.')) throw new \Exception('param key does not contain "."');
        $keyInfo = explode('.', $key);
        $configFile = $keyInfo[0];

        if(!isset(self::$config[$configFile])) {
            $realConfigFile = self::$config_path . DIRECTORY_SEPARATOR . $configFile . '.php';
            if(!file_exists($realConfigFile)) throw new \Exception('config file is not exists. filename:'. $realConfigFile);
            if(!is_readable($realConfigFile)) throw new \Exception('config file is not readable');

            self::$config[$configFile] = include $realConfigFile;
        }
    }
}