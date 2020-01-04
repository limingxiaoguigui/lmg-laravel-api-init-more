<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2019-12-28 00:00:48
 * @LastEditors  : LMG
 * @LastEditTime : 2019-12-29 18:06:44
 */

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

class FormRequest extends BaseFormRequest
{
    public function authorize()
    {
        //false代表权限验证不通过，返回403错误
        //true代表权限认证通过
        return true;
    }
}