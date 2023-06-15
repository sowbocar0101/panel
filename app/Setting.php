<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','footer','status','status_del','user_id','email'
    ];

    public static function getSetting(){
        return Setting::where('status_del',1)->get();
    }
}