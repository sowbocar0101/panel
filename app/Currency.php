<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libelle','symbole','status','status_del','user_id'
    ];

    public static function getCurrency(){
        return Currency::where('status_del',1)->get();
    }
}