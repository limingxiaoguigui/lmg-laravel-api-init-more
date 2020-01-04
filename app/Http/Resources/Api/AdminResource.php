<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2019-12-28 23:52:37
 * @LastEditors  : LMG
 * @LastEditTime : 2019-12-30 17:45:41
 */

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Enum\AdminEnum;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => AdminEnum::getStatusName($this->status),
            'created_at' => (string) $this->created_at,
            'updated_ta' => (string) $this->updated_at
        ];
    }
}