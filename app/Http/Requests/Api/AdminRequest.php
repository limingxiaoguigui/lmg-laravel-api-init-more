<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2019-12-28 00:06:57
 * @LastEditors  : LMG
 * @LastEditTime : 2019-12-30 17:46:44
 */

namespace App\Http\Requests\Api;


class AdminRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //根据方法不同验证规则不同
        switch ($this->method()) {
            case 'GET':
                return [
                    'id' => 'required|exists:shop_user,id'
                ];

            case 'POST':
                return [
                    'name' => 'required|max:12|unique:users,name',
                    'password' => 'required|max:16|min:6'
                ];

            case 'PUT':
            case 'PATCH':
            case 'DELETE':
            default:
                return [];
        }
    }

    /**
     * 验证提示消息
     * @return void
     */
    public function messages()
    {
        return [
            'id.required' => '用户ID必须填写',
            'id.exists' => '用户不存在',
            'name.unique' => '用户名已经存在',
            'name.required' => '用户名不能为空',
            'name.max' => '用户名最大长度为12个字符',
            'password.required' => '密码不能为空',
            'password.max' => '密码长度不能超过16个字符',
            'password.min' => '密码长度不能小于6个字符'

        ];
    }
}