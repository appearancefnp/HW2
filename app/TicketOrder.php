<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketOrder extends Model
{
    public function order() {
        return $this->belongsTo('App\Order');
    }
    public function ticket() {
        return $this->belongsTo('App\Ticket');
    }
}
