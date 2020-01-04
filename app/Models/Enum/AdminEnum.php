<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2019-12-28 23:24:01
 * @LastEditors  : LMG
 * @LastEditTime : 2019-12-30 17:44:40
 */

namespace App\Models\Enum;

class AdminEnum
{

    //状态类别
    const INVALID = -1; //已删除
    const NORMAL = 0; //正常
    const FREEZE = 1; //冻结

    /**
     * 获取状态值
     * @param [type] $status
     * @return void
     */
    public static function getStatusName($status)
    {
        switch ($status) {
            case self::INVALID:
                return '已删除';
                break;
            case self::NORMAL:
                return '正常';
                break;
            case self::FREEZE:
                return '冻结';
                break;
            default:
                return '正常';
                break;
        }
    }
}