<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/7/1
 * Time: 11:17
 */

namespace Jenner\Wechat\Tool;


class Http
{
    private $url;
    //代理IP
    private $proxyIp;
    //代理服务器端口
    private $proxyPort;
    //超时时间
    private $timeOut;
    //连接超时时间
    private $connectTimeout;
    //HTTP响应状态码
    private $httpStatus;

    /**
     * @param $url
     * @param string $proxyIp
     * @param int $proxyPort
     * @param int $connectTimeout
     * @param int $timeOut
     * @throws \Exception
     * @internal param int $transferTimeOut
     */
    public function __construct($url, $proxyIp = '', $proxyPort = 0, $connectTimeout = 10, $timeOut = 300)
    {
        //URL地址
        if (!$url) throw new \Exception("必须指定URL地址！");
        $this->url = $url;
        $this->timeOut = $timeOut;
        $this->connectTimeout = $connectTimeout;
        //代理服务器I的设置
        if ($proxyIp) {
            $this->proxyIp = $proxyIp;
            $this->proxyPort = $proxyPort ? $proxyPort : 80;
        }
    }

    /**
     * 设置代理服务器
     * @param $ip
     * @param int $port
     */
    public function setProxy($ip, $port = 80)
    {
        if ($ip) {
            $this->proxyIp = $ip;
            $this->proxyPort = $port;
        }
    }

    /**
     * GET请求
     * @param null $params
     * @return mixed
     */
    public function GET($params = null)
    {
        //组合带参数的URL
        $url = &$this->url;
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
        $this->initProxy($curl);
        $this->initCurlParam($curl);
        $content = curl_exec($curl);
        $this->httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return $content;
    }

    /**
     * POST请求，支持文件上传
     * 文件上传的params格式['key'=>'@file_path/filename']
     * @param null $params
     * @param bool $fileUpload
     * @return mixed
     */
    public function POST($params = null, $fileUpload = false)
    {
        //初始化curl
        $curl = curl_init();
        $this->initProxy($curl);
        $this->initCurlParam($curl);
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
        } elseif ($params) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        }
        $content = curl_exec($curl);
        $this->httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return $content;
    }

    /**
     * 获取HTTP状态码
     * @return mixed
     */
    public function getStatus()
    {
        return $this->httpStatus;
    }

    /**
     * 初始化代理
     * @param $curl
     */
    private function initProxy($curl)
    {
        if ($this->proxyIp && $this->proxyPort) {
            $proxy = "http://{$this->proxyIp}:{$this->proxyPort}";
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }
    }

    /**
     * 初始化CURL参数
     * @param $curl
     */
    private function initCurlParam($curl)
    {
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeOut);
    }
}