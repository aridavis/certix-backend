<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public static function findGenreByName($name){
        return Genre::where('name', '=', $name)->first();
    }
}
