<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'niveau','conducteur_id','status','status_del','user_id','statut','user_app_id'
    ];

    public static function getNote(){
        return Note::where('status_del',1)->get();
    }
}