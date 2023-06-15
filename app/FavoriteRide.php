<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoriteRide extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'latitude_depart','longitude_depart','status','status_del','user_id','latitude_arrivee','longitude_arrivee','depart_name','destination_name','distance','statut','user_app_id','libelle'
    ];

    public static function getFavoriteRide(){
        return FavoriteRide::where('status_del',1)->get();
    }
}