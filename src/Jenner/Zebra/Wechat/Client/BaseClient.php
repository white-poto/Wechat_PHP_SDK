<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-17
 * Time: 下午2:50
 */

namespace Jenner\Zebra\Wechat\Client;


use Jenner\Zebra\Wechat\Exception\ResponseErrorException;

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

    public function getCode(){
        return $this->error_code;
    }

    public function checkResponse($response_json){
        $response = json_decode($response_json, true);
        if(isset($response['errcode'])){
            throw new ResponseErrorException($response['errmsg'], $response['errcode']);
        }

        return $response;
    }
} 