<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleRental extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre','prix','status','status_del','user_id','nb_place','image','id_type_vehicule_rental','statut'
    ];

    public static function getVehicleRental(){
        return VehicleRental::where('status_del',1)->get();
    }
}