<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libelle','code','status','status_del','user_id'
    ];

    public static function getCountry(){
        return Country::where('status_del',1)->get();
    }
}