<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libelle','prix','status','status_del','user_id','image'
    ];

    public static function getVehicleType(){
        return VehicleType::where('status_del',1)->get();
    }
}