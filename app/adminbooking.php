<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class adminbooking extends Model
{
    protected $table = 'adminbookings';
    protected $fillable=[
	'admin_username',
	'hall_booked',
	'start_date',
	'end_date',
	'start_time',
	'end_time'
	];
}
