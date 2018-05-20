<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [ 'deposit', 'amount', 'user_id'];

    /**
     * User relation.
     * 
     * @return type
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
