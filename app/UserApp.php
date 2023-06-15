<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserApp extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom','prenom','status','status_del','user_id','email','phone','mdp','login_type','photo','photo_path','tonotify','device_id','fcm_id','amount','statut'
    ];

    public static function getUserApp(){
        return UserApp::where('status_del',1)->get();
    }
}