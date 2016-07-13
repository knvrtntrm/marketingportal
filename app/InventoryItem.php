<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected $table = "inventoryitems";

    public function client(){
        return $this->hasOne('\App\User','id','client_id');
    }

    public function condition(){
        return $this->hasOne('\App\Condition','id','condition_id');
    }

    public function requests(){
        return $this->belongsToMany('App\Request','inventoryitem_request','request_id','inventoryitem_id')->withPivot('amount');
    }

    protected $fillable = [
      'location_id',
      'condition_id',
      'inStock'
    ];
}
