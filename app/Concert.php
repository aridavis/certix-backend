<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Concert extends Model
{
    //
    protected $keyType = "string";
    public $incrementing = false;

    public static function findConcertById($id){
        return Concert::where("id", '=', $id)->first();
    }
}
