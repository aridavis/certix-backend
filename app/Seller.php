<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $keyType = "string";
    public $incrementing = false;

    public function user(){
        $this->belongsTo(User::class);
    }

    public function concert(){
        return $this->hasMany(Concert::class);
    }

    public static function findSellerByUserId($id){
        return Seller::where("user_id", '=', $id)->first();
    }

    public static function findSellerByRequest($request){
        return Seller::where("user_id", '=', $request->user()->id)->first();
    }

}
