<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drukwerk extends Model
{
    protected $table = "drukwerk";

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'size',
        'presstype',
        'color',
        'digital',
        'onlydigital',
        'extra',
        'purpose',
        'status',
        'deadline',
        'finished'
    ];

    public function state(){
        return $this->hasOne('App\Status','id','status');
    }

    public function client(){
        return $this->hasOne('\App\User','id','user_id');
    }
}
