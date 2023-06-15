<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand','model','status','status_del','user_id','color','numberplate','passenger','conducteur_id','id_type_vehicule','statut'
    ];

    public static function getVehicle(){
        return Vehicle::where('status_del',1)->get();
    }
}