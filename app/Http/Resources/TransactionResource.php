<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;

class TransactionResource extends Resource
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
            'amount'    =>  number_format($this->amount, 2, '.', ','),
            'type'      =>  $this->type,
            'date'      =>  Carbon::parse($this->created_at)->format('Y-m-d')
        ];
    }
}
