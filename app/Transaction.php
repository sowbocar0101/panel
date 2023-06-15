<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount','user_app_id','status','status_del','user_id'
    ];

    public static function getTransaction(){
        return Transaction::where('status_del',1)->get();
    }
}