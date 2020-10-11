<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewType extends Model
{
    public function reviewDetail(){
        $this->belongsToMany(ReviewDetail::class);
    }
}
