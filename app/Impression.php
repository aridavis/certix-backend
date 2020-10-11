<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Impression extends Model
{
    protected $keyType = "string";
    public $incrementing = false;

    public function concert(){
        return $this->belongsTo(Concert::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
