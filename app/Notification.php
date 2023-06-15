<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titre','message','status','status_del','user_id'
    ];

    public static function getNotification(){
        return Notification::where('status_del',1)->get();
    }
}