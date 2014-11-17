<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-13
 * Time: 上午11:37
 *
 * 微信响应接口
 */

namespace Jenner\Zebra\Wechat\Response;


/**
 * 用于回复的基本消息类型
 */
abstract class XmlResponse
{
    /**
     * @var
     */
    protected $replace;
    /**
     * @var
     */
    protected $template;

    /**
     * @param $to_user
     * @param $from_user
     */
    public function __construct($to_user, $from_user)
    {
        $this->replace['ToUserName'] = $to_user;
        $this->replace['FromUserName'] = $from_user;
        $this->initTemplate();
    }

    /**
     * @param $content
     * @throws \Exception
     */
    protected function checkContent($content){
        if(!is_array($content)){
            throw new \Exception('param content for Response::create must be a array');
        }
    }

    /**
     * @return mixed
     */
    abstract protected function initTemplate();

    /**
     * @param $content
     * @return mixed
     */
    public function create($content)
    {
        $this->checkContent($content);
        $replace = array_merge($this->replace, $content);
        $replace['CreateTime'] = time();
        $replace_keys = array_keys($replace);
        $response = $this->template;
        foreach($replace_keys as $key){
            //字符串转换，使其支持下划线、中划线写法
            if(strstr($key, '-') || strstr($key, '_')){
                $search = '{' . $this->studlyCase($key) . '}';
            }else{
                $search = '{' . $key . '}';
            }
            if(!strstr($response, $search)) continue;
            $response = str_replace($search, $replace[$key], $response);
        }

        return $response;
    }

    /**
     * 将foo_bar foo-bar格式的字符串转换为FooBar
     * @param $value
     * @return mixed
     */
    protected function studlyCase($value)
    {
        $value = ucwords(str_replace(array('-', '_'), ' ', $value));

        return str_replace(' ', '', $value);
    }

}