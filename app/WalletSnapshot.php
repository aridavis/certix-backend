<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalletSnapshot extends Model
{
    protected $keyType = "string";
    public $incrementing = false;

    public function user(){
        return $this->belongsTo(User::class);
    }

}
