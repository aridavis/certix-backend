<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{

    protected $keyType = "string";
    public $incrementing = false;

    public function user(){
        return $this->belongsTo(User::class);
    }
}
