<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleTypeRental extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libelle','prix','status','status_del','user_id','image'
    ];

    public static function getVehicleTypeRental(){
        return VehicleTypeRental::where('status_del',1)->get();
    }
}