<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $keyType = "string";
    public $incrementing = false;

    public function ticketDetail(){
        $this->belongsTo(TicketDetail::class);
    }

    public function reviewDetail(){
        $this->hasMany(ReviewDetail::class);
    }

}
