<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    public static function findSellerByUserId($id){
        return Seller::where("user_id", '=', $id)->first();
    }
}
