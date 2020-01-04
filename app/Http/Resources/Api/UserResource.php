<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2019-12-28 23:52:37
 * @LastEditors  : LMG
 * @LastEditTime : 2019-12-29 09:42:21
 */

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Enum\UserEnum;

class UserResource extends JsonResource
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
            'status' => UserEnum::getStatusName($this->status),
            'created_at' => (string) $this->created_at,
            'updated_ta' => (string) $this->updated_at
        ];
    }
}