<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $keyType = "string";
    public $incrementing = false;

    public static function getProgress($id){
        $ticket_referred = Ticket::where("referral_id", '=', $id)->get();
        return $ticket_referred->count();
    }

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
