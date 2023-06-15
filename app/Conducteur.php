<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conducteur extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom','prenom','status','status_del','user_id','cnib','phone','mdp','latitude','longitude','email','statut_licence','statut_nic','statut_vehicule','online','login_type','photo','photo_path','photo_licence','photo_licence_path','photo_nic','photo_nic_path','tonotify','device_id','fcm_id','amount','statut'
    ];

    public static function getConducteur(){
        return Conducteur::where('status_del',1)->get();
    }
}