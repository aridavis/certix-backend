<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewDetail extends Model
{
    protected $keyType = "string";
    public $incrementing = false;

    public function review(){
        $this->belongsTo(Review::class);
    }

    public function reviewType(){
        $this->hasMany(ReviewType::class);
    }
}
