<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2019-12-27 22:58:55
 * @LastEditors  : LMG
 * @LastEditTime : 2019-12-29 17:57:38
 */

namespace App\Exceptions;

use App\Api\Helpers\ExceptionReport;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{

    protected $dontReport = [
        //
    ];
    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];
    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * 捕捉异常
     * @param [type] $request
     * @param \Exception $exception
     * @return void
     */
    public function render($request, Exception $exception)
    {
        //ajax请求我们才能捕捉异常
        if ($request->ajax()) {
            //将方法拦截到自己的ExceptionReport中
            $reporter = ExceptionReport::make($exception);
            //判断是否需要抛异常
            if ($reporter->shouldReturn()) {
                //记录异常
                return $reporter->report();
            }
            if (env('APP_DEBUG')) {
                //开发环境，则显示详细的错误信息
                return parent::render($request, $exception);
            } else {
                //线上环境，位置错误，则显示500
                return $reporter->prodReport();
            }
        }
    }
}