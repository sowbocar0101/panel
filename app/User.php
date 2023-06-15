<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom', 'prenom', 'phone', 'email', 'password', 'status', 'email_verified_at','old_password',
        'code_enregistrement_patient', 'date_prelevement_patient', 'site_prelevement_patient', 'nom_patient', 'prenom_patient', 'date_naissance_patient', 'age_annee_patient','age_mois_patient',
        'age_jour_patient', 'sexe_patient', 'ville_village_patient', 'quartier_secteur_patient', 'residence_patient', 'nom_pere_mere_tuteur_patient', 'phone_patient','email_patient','password_patient','patient_status',
        'phone2_patient','phone3_patient','service_responsable_id','service_responsable_sgs_id','categorie'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getUsers(){
        return User::all();
    }
}