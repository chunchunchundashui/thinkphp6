<?php


namespace app\common\controller\exception;


use think\Exception;
use Throwable;

class BaseException extends Exception
{
    // 成员变量
    public $code = 400;
    public $msg  = '异常';
    public $errorCode = 999;

    public function __construct($params = [])
    {
        if(!is_array($params)) return;
        if(array_key_exists('code', $params)) $this->code = $params['code'];
        if(array_key_exists('msg', $params)) $this->msg = $params['msg'];
        if(array_key_exists('errorCode', $params)) $this->errorCode = $params['errorCode'];
    }
}