<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketDetail extends Model
{
    protected $keyType ="string";
    public $incrementing = false;

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }
}
