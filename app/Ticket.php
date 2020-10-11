<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $keyType = "string";
    public $incrementing = false;

    public function ticketDetail(){
        return $this->hasMany(TicketDetail::class);
    }

    public function concert(){
        $this->belongsTo(Concert::class);
    }
}
