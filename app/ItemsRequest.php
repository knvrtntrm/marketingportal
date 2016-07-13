<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemsRequest extends Model
{
    protected $table = 'requests';

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

    public function inventoryitems(){
        return $this->belongsToMany('App\InventoryItem','inventoryitem_request','request_id','inventoryitem_id')->withPivot('amount');
    }
}
