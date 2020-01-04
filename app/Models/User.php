<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2019-12-27 22:58:55
 * @LastEditors  : LMG
 * @LastEditTime : 2019-12-29 23:39:10
 */

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable  implements JWTSubject
{
    use Notifiable;

    /**
     * 获取将存储在JWT主题声明中的标识符。
     * @return void
     */
    public function getJWTIdentifier()
    {
        return  $this->getKey();
    }

    /**
     * 返回一个键值数组，其中包含要添加到JWT的任何自定义声明。
     * @return void
     */
    public function getJWTCustomClaims()
    {
        return  [];
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'last_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'last_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 将密码进行加密
     *
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}