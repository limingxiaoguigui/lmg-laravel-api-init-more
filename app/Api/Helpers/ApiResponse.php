<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2019-12-28 22:41:35
 * @LastEditors  : LMG
 * @LastEditTime : 2019-12-28 23:20:03
 */

namespace App\Api\Helpers;

use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use Response;

/**
 * 返回响应Trait
 */
trait ApiResponse
{

    /**
     * 状态码
     * @var int
     */
    protected $statusCode = FoundationResponse::HTTP_OK;

    /**
     * 获取状态码
     * @return void
     */
    public function getStatusCode()
    {

        return $this->statusCode;
    }

    /**
     * 设置状态码
     * @param [type] $statusCode
     * @param [type] $httpCode
     * @return void
     */
    public function setStatusCode($statusCode, $httpCode = null)
    {
        $httpCode = $httpCode ?? $statusCode;
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * 响应
     * @param [type] $data
     * @param array $header
     * @return void
     */
    public function respond($data, $header = [])
    {
        return Response::json($data, $this->getStatusCode(), $header);
    }

    /**
     * 状态
     * @param [type] $status
     * @param array $data
     * @param [type] $code
     * @return void
     */
    public function status($status, array $data, $code = null)
    {
        if ($code) {
            $this->setStatusCode($code);
        }
        $status = [
            'status' => $status,
            'code' => $this->statusCode
        ];
        $data = array_merge($status, $data);

        return $this->respond($data);
    }

    /**
     * 请求失败
     * @param [type] $message
     * @param [type] $code
     * @param string $status
     * @return void
     * 格式
     * data:
     *  code:422
     *  message:xxx
     *  status:'error'
     */
    public function failed($message, $code = FoundationResponse::HTTP_BAD_REQUEST, $status = 'error')
    {
        return $this->setStatusCode($code)->message($message, $status);
    }

    /**
     * 返回消息提示
     * @param [type] $message
     * @param string $status
     * @return void
     */
    public function message($message, $status = 'success')
    {

        return $this->status($status, ['message' => $message]);
    }

    /**
     * 非法请求
     * @param string $message
     * @return void
     */
    public function internalError($message = 'Internal Error!')
    {
        return $this->failed($message, FoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * 创建成功
     * @param string $message
     * @return void
     */
    public function created($message = 'created')
    {
        return $this->setStatusCode(FoundationResponse::HTTP_CREATED)->message($message);
    }

    /**
     * 请求成功
     * @param [type] $data
     * @param string $status
     * @return void
     */
    public function success($data, $status = 'success')
    {
        return $this->status($status, compact('data'));
    }

    /**
     * 找不到页面
     * @param string $message
     * @return void
     */
    public function notFound($message = 'Not Found!')
    {
        return $this->failed($message, FoundationResponse::HTTP_NOT_FOUND);
    }
}