<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $keyType = "string";
    public $incrementing = false;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function concert(){
        return $this->belongsTo(Concert::class);
    }

    public static function getConcertId($id){
        return Referral::where("id", '=', $id)->first()->concert_id;
    }
}
