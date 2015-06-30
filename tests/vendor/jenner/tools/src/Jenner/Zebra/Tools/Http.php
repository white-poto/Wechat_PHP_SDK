<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-17
 * Time: 上午11:28
 */

namespace Jenner\Zebra\Tools;


class Http {

    private $url;
    private $proxyIp;
    private $proxyPort;
    private $timeOut;
    private $transferTimeOut;

    public function __construct($url, $proxyIp = '', $proxyPort = 0, $timeOut = 10, $transferTimeOut = 600) {

        //URL地址
        if (!$url) throw new JetException("必须指定URL地址！");
        $this->url = $url;
        $this->timeOut = $timeOut;
        $this->transferTimeOut = $transferTimeOut;

        //代理服务器I的设置
        if ($proxyIp) {
            $this->proxyIp = $proxyIp;
            $this->proxyPort = $proxyPort ? $proxyPort : 80;
        }

    }

    public function setProxy($ip, $port = 80) {
        if ($ip) {
            $this->proxyIp = $ip;
            $this->proxyPort = $port;
        }
    }

    public function GET($params = null) {

        //组合带参数的URL
        $url = $this->url;
        if ($params && is_array($params)) {
            $url .= '?';
            $amp = '';
            foreach ($params as $paramKey => $paramValue) {
                $url .= $amp . $paramKey . '=' . urlencode($paramValue);
                $amp = '&';
            }
        }

        //初始化curl
        $curl = curl_init();
        if ($this->proxyIp && $this->proxyPort) {
            $proxy = "http://{$this->proxyIp}:{$this->proxyPort}";
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeOut);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->transferTimeOut);

        $content = curl_exec($curl);
        curl_close($curl);

        return $content;

    }

    public function POST($params = null, $fileUpload = false) {

        //初始化curl
        $curl = curl_init();
        if ($this->proxyIp && $this->proxyPort) {
            $proxy = "http://{$this->proxyIp}:{$this->proxyPort}";
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeOut);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->transferTimeOut);

        //设置POST参数
        curl_setopt($curl, CURLOPT_POST, 1);
        if ($params && is_array($params)) {
            if ($fileUpload) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            } else {
                $amp = '';
                $postFields = '';
                foreach ($params as $paramKey => $paramValue) {
                    $postFields .= $amp . $paramKey . '=' . urlencode($paramValue);
                    $amp = '&';
                }
                curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);
            }
        }

        $content = curl_exec($curl);
        curl_close($curl);

        return $content;

    }

}