<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
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
            'name'              =>  $this->name,
            'email'             =>  $this->email,
            'amount'            =>  number_format($this->amount, 2, '.', ','),
            'bonuse_percentage' =>  $this->bonus_percent."%",
            'country'           =>  $this->country->full_name
        ];
    }
}
