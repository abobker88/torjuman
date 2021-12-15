<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleUser extends JsonResource
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
            'id'=>$this->id,
            'name'=>$this->name,
            'email'=>$this->email,
            'mobile'=>$this->mobile,
            'token'=>$this->api_token
            // 'avatar'=>$this->avatar_path,
            // 'gender'=>$this->gender,
            // 'type'=>$this->type,
            // 'mobile_verified'=>$this->mobile_verified==0?false:true,


        ];
    }
}
