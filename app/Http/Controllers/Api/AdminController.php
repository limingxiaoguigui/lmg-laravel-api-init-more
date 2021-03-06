<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2019-12-27 23:35:26
 * @LastEditors  : LMG
 * @LastEditTime : 2020-01-02 15:36:15
 */

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AdminRequest;
use App\Http\Resources\Api\AdminResource;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use App\Jobs\Api\SaveLatTokenJob;

class AdminController extends Controller
{
    /**
     *
     * 返回用户列表
     *
     */

    public function index()
    {

        //三个用户为一页
        $admins = Admin::paginate(3);

        return AdminResource::collection($admins);
    }
    /**
     * 返回单一用户信息
     * @param \App\Models\Admin $admin
     * @return void
     */
    public function show(Admin $admin)
    {
        // 3 / 0;
        return $this->success(new AdminResource($admin));
    }

    /**
     *
     * 用户注册
     */

    public function store(AdminRequest $request)
    {

        Admin::create($request->all());

        return $this->setStatusCode(201)->success('用户注册成功');
    }


    /**
     * 用户登录
     * @param  $request
     * @return void
     */
    public function login(Request $request)
    {
        //获取当前守护的名称
        $present_guard = Auth::getDefaultDriver();
        $token = Auth::claims(['guard' => $present_guard])->attempt(['name' => $request->name, 'password' => $request->password]);
        if ($token) {
            //如果登陆，先检查原先是否有存token，有的话先失效，然后再存入最新的token
            $user = Auth::user();

            if ($user->last_token) {
                try {

                    Auth::setToken($user->last_token)->invalidate();
                } catch (TokenExpiredException $e) {
                    //因为让一个过期的token再失效，会抛出异常，所以我们捕捉异常，不需要做任何处理
                }
            }
            //分发任务
            SaveLatTokenJob::dispatch($user, $token);
            return $this->setStatusCode(201)->success(['token' => 'bearer ' . $token]);
        }
        return $this->failed('账号或密码错误', 400);
    }

    /**
     * 退出登录
     * @return void
     */
    public function logout()
    {
        Auth::logout();
        return $this->success('退出成功。。。');
    }

    /**
     * 返回当前登录用户信息
     * @return void
     */
    public function info()
    {
        $admin = Auth::user();
        return  $this->success(new AdminResource($admin));
    }
}