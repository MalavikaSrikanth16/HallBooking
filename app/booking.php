<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class booking extends Model
{
	protected $table = 'booking';
    protected $fillable=[
	'id',
	'date',
	'hall_booked',
	'prof_name',
	'webmail_id'
	];

}
