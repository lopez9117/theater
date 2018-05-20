<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = [
        'seat', 'taken','reservation_id'
    ];
}
