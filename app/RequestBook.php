<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestBook extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'depart_name','destination_name','status','status_del','user_id','latitude_depart','longitude_depart','latitude_arrivee','longitude_arrivee','place','number_poeple','distance','duree','montant','trajet','statut_paiement','date_retour','heure_retour','statut_round','id_vehicule_rental','id_user_app','id_conducteur','id_payment_method','statut','date_book','nb_day','heure_depart','cu'
    ];

    public static function getRequestBook(){
        return RequestBook::where('status_del',1)->get();
    }
}