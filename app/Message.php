<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function sender()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }

    public function reciver()
    {
        return $this->belongsTo('App\User', 'reciver_id');
    }
}
