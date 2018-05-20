<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'date', 'number_persons','user_id'
    ];
}
