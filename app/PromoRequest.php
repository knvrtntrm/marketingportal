<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoRequest extends Model
{
    protected $table = 'promorequests';

    protected $fillable = [
        'client_id',
        'comment',
        'status'
    ];

    public function client(){
        return $this->hasOne('App\User','id','client_id');
    }

    public function state(){
        return $this->hasOne('App\Status','id','status');
    }

    public function promoitems(){
        return $this->belongsToMany('App\PromoItem','promoitem_promorequest','promorequest_id','promoitem_id')->withPivot('amount');
    }
}
