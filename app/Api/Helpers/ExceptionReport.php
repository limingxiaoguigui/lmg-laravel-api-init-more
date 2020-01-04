<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2019-12-29 09:59:28
 * @LastEditors  : LMG
 * @LastEditTime : 2019-12-29 18:00:10
 */

namespace App\Api\Helpers;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class ExceptionReport
{
    use ApiResponse;

    /**
     * 异常
     * @var [type]
     */
    public $exception;

    /**
     * 请求
     * @var [type]
     */
    public $request;

    /**
     * 记录
     * @var [type]
     */
    protected $report;

    /**
     * 构造方法
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     */
    public function __construct(Request $request, Exception $exception)
    {
        $this->request = $request;
        $this->exception = $exception;
    }

    /**
     * 当抛出这些异常时，可以使用我们定义的错误信息与HTTP状态码,可以把常见异常放在这里
     * @var array
     */
    public $doReport = [
        AuthenticationException::class => ['未授权', 401],
        ModelNotFoundException::class => ['该模型未找到', 404],
        AuthorizationException::class => ['没有此权限', 403],
        ValidationException::class => [],
        UnauthorizedHttpException::class => ['未登录或登录状态失效', 422],
        TokenInvalidException::class => ['token不正确', 400],
        NotFoundHttpException::class => ['没找到该页面', 404],
        MethodNotAllowedHttpException::class => ['访问方式不正确', 405],
        QueryException::class => ['参数错误', 401]

    ];

    /**
     * 注册异常
     * @param [type] $className
     * @param callable $callback
     * @return void
     */
    public function register($className, callable $callback)
    {

        $this->doReport[$className] = $callback;
    }

    /**
     * 是否应该抛异常
     * @return boolean
     */
    public function shouldReturn()
    {
        //只有请求包含是json或者ajax请求时才有效
        //        if (! ($this->request->wantsJson() || $this->request->ajax())){
        //
        //            return false;
        //        }
        foreach (array_keys($this->doReport) as $report) {
            if ($this->exception instanceof $report) {
                $this->report = $report;
                return true;
            }
        }
        return false;
    }

    /**
     * 捕捉异常
     * @param \Exception $e
     * @return void
     */
    public static function make(Exception $e)
    {
        return new static(\request(), $e);
    }

    /**
     * 记录异常
     * @return void
     */
    public function report()
    {
        //验证异常
        if ($this->exception instanceof ValidationException) {
            //方法返回第一个 满足匿名函数（该匿名函数作为参数传入） 返回true的元素的
            $error = array_first($this->exception->errors());
            return  $this->failed(array_first($error), $this->exception->status);
        }

        $message = $this->doReport[$this->report];
        return  $this->failed($message[0], $message[1]);
    }

    /**
     * 服务器环境错误
     * @return void
     */
    public function prodReport()
    {

        return $this->failed('服务器错误', '500');
    }
}