<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $table = 'tickets';

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function messages() {
        return $this->hasMany('App\SupportTicketMessage', 'ticket_id', 'id');
    }
}
