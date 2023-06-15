<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libelle','value','type','status','status_del','user_id','statut'
    ];

    public static function getCommission(){
        return Commission::where('status_del',1)->get();
    }
}