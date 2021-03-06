<?php
namespace app;

use app\common\controller\exception\BaseException;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\Handle;
use think\exception\HttpException;
use think\exception\HttpResponseException;
use think\exception\ValidateException;
use think\Response;
use Throwable;

/**
 * 应用异常处理类
 */
class ExceptionHandle extends Handle
{
    // 成员变量
    public $code;
    public $msg;
    public $errorCode;

    /**
     * 不需要记录信息（日志）的异常类列表
     * @var array
     */
    protected $ignoreReport = [
        HttpException::class,
        HttpResponseException::class,
        ModelNotFoundException::class,
        DataNotFoundException::class,
        ValidateException::class,
    ];

    /**
     * 记录异常信息（包括日志或者其它方式记录）
     *
     * @access public
     * @param  Throwable $exception
     * @return void
     */
    public function report(Throwable $exception): void
    {
        // 使用内置的方式记录异常日志
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param \think\Request   $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        // 添加自定义异常处理机制
        if ($e instanceof BaseException) {
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        } else {
            // 开启debug模式， 默认抛出框架自带异常处理
            if (config('app.show_error_msg')) return parent::render($request, $e);
            $this->code = 500;
            $this->msg = '服务器异常';
            $this->errorCode = 999;
        }
        $res  = [
            'code' => $this->code,
            'msg' => $this->msg,
            'errorCode' => $this->errorCode
        ];
        return json($res, $this->code);
        // 其他错误交给系统处理
//        return parent::render($request, $e);
    }
}
