<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellerApplication extends Model
{
    protected $keyType = "string";
    public $incrementing = false;

    public function status(){
        $this->hasOne(Status::class);
    }
}
