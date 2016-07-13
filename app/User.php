<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','budget'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    
    public function orders(){
        return $this->hasMany('\App\PromoRequest','client_id','id');
    }
    
    public function setPasswordAttribute($password)
    {   
        $this->attributes['password'] = bcrypt($password);
    }
   

}
