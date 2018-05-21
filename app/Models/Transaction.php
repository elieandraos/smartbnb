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

     /**
     * scope that queries after a certain created date.
     * 
     * @param type $query 
     * @return type
     */
    public function scopeAfterDate($query, $date)
    {
        if(!$date)
            return $query;

        return $query->whereDate('created_at', '>=', $date);
    }

    /**
     * scope that queries before a certain created date.
     * 
     * @param type $query 
     * @return type
     */
    public function scopeBeforeDate($query, $date)
    {
        if(!$date)
            return $query;

        return $query->whereDate('created_at', '<=', $date);
    }
}
