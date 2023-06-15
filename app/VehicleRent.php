<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleRent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nb_jour','date_debut','status','status_del','user_id','date_fin','contact','id_vehicule_rental','id_user_app','statut'
    ];

    public static function getVehicleRent(){
        return VehicleRent::where('status_del',1)->get();
    }
}