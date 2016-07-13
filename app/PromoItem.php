<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoItem extends Model
{
    protected $table = "promoitems";

    protected $fillable = [
        'amountinstock',
        'available'
    ];

    public function requests(){
        return $this->belongsToMany('App\Request','promoitem_request','request_id','promoitem_id')->withPivot('amount');
    }
}
