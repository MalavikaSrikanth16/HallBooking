<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bookedSlot extends Model
{
	protected $table = 'booked_slots';
    protected $fillable=[
	'id',
	'booking_id',
	'slot_id'
	];

}
