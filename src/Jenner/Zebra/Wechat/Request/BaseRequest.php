<?php


/**
 * @author Jenner
 * @version 1.0
 * @created 2014-11-14
 */
abstract class BaseRequest
{

	protected $attribute;
	protected $items;

    function create()
    {
        $request_array = $this->toArray();
        return json_encode($request_array);
    }

    function toArray(){
        return array_merge($this->attribute, $this->items);
    }

	function getMsgtype()
	{
        return isset($this->attribute['msgtype']) ? $this->attribute['msgtype'] : false;
	}

	function getToUser()
	{
        return isset($this->attribute['touser']) ? $this->attribute['touser'] : false;
	}

	/**
	 * 
	 * @param msgtype
	 */
	function setMsgtype($msgtype)
	{
        $this->attribute['msgtype'] = $msgtype;
	}

	/**
	 * 
	 * @param to_user
	 */
	function setToUser($to_user)
	{
        $this->attribute['touser'] = $to_user;
	}

}
?>