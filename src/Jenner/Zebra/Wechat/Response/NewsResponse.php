<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 14-11-13
 * Time: 下午12:15
 */

namespace Jenner\Zebra\Wechat\Response;


/**
 * 用于回复的图文消息类型
 */
class NewsResponse extends XmlResponse {

    protected $item_template;

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

    protected function createItemTemplate($content, $response){
        if(!isset($content['item']) || empty($content['item'])){
            throw new \Exception('item can not be empty in NewsResponse');
        }
        $items = $content['item'];
        $item_count = count($items);
        $response = str_replace('{ArticleCount}', $item_count, $response);

        $item_response = '';
        foreach($items as $item){
            $replace = $this->item_template;
            foreach($item as $item_key=>$item_value){
                //字符串转换，使其支持下划线、中划线写法
                if(strstr($item_key, '-') || strstr($item_key, '_')){
                    $search = '{' . $this->studlyCase($item_key) . '}';
                }else{
                    $search = '{' . $item_key . '}';
                }
                if(!strstr($response, $search)) continue;
                $item_response = str_replace($search, $replace[$item_key], $response);
                $item_response .= PHP_EOL;
            }
        }
        $response = str_replace('{item}', $item_response, $response);

        return $response;
    }

    protected function initTemplate()
    {
        $this->template = <<<XML
<xml>
<ToUserName><![CDATA[{ToUserName}]]></ToUserName>
<FromUserName><![CDATA[{FromUserName}]]></FromUserName>
<CreateTime>{CreateTime}</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>{ArticleCount}</ArticleCount>
<Articles>
{item}
</Articles>
</xml>
XML;
    }

    protected function initItemTemplate(){
        $this->item_template = <<<XML
<item>
<Title><![CDATA[{Title}]]></Title>
<Description><![CDATA[{Description}]]></Description>
<PicUrl><![CDATA[{PicUrl}]]></PicUrl>
<Url><![CDATA[{Url}]]></Url>
</item>
XML;
    }
}