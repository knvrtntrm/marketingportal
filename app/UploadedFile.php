<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadedFile extends Model
{
    protected $table = "uploaded_files";

    public function user(){
        return $this->belongsTo('App\User');
    }
}
