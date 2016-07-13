<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emailhandtekening extends Model
{
    protected $table = "emailhandtekeningen";

    protected $fillable = [
        'name',
        'user_id',
        'approved',
        'function',
        'image',
        'gsm'
    ];

    public function funct(){
        return $this->hasOne('\App\Functies','id','function');
    }
}
