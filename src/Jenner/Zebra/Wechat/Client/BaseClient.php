<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-17
 * Time: 下午2:50
 */

namespace Jenner\Zebra\Wechat\Client;


class BaseClient
{
    /**
     * @var
     */
    protected $error_code = 0;

    /**
     * @var
     */
    protected $error_message;

    public function isError()
    {
        return $this->error_code !== 0;
    }

    public function getMessage()
    {
        return $this->error_message;
    }

    public function checkResponse($response_json){
        $response = json_decode($response_json, true);
        if(!isset($response['errcode'])){
            $this->error_code = $response['errcode'];
            $this->error_message = $response['errmsg'];
            return false;
        }else{
            return $response;
        }
    }
} 