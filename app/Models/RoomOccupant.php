<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class RoomOccupant extends Model
{
    protected $table = 'room_occupants';

    public $timestamps = false;

    protected $fillable = [
        'room_id',
        'occupant_id',
        'occupant_type',
    ];
}
