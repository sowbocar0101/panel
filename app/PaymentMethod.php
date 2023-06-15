<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libelle','status','status_del','user_id','image'
    ];

    public static function getPaymentMethod(){
        return PaymentMethod::where('status_del',1)->get();
    }
}