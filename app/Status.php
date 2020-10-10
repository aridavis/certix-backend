<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public static function findStatusByName($name){
        return Status::where('name', '=', $name)->first();
    }
}
