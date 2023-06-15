<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Langue extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libelle','abreviation','status','status_del','user_id','default','icon'
    ];

    public static function getLangue(){
        return Langue::where('status_del',1)->get();
    }
}