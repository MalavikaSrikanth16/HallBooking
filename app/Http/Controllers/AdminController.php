<?php

namespace App\Http\Controllers;


use Auth;
use App\hall;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class AdminController extends Controller
{
    public function getHalls(Request $request)
    {
    	$location = $request->input('location');
    	$halls = hall::all()->where('location', $location);

    	return view('adminHalls', compact('halls', 'location'));
    }

    public function bookHalls(Request $request)
    {
    	$hallid = $request->input('halls');
    	$user = Auth::user()->name; //As of now only 'admin' 
    	$startdate = $request->input('startDate');    	
    	$enddate = $request->input('endDate');
    	$starttime = $request->input('startTime');
    	$endtime = $request->input('endTime');

    	DB::table('adminbookings')->insert(['hall_booked' => $hallid, 'admin_username' => $user, 'start_date'=> $startdate, 'end_date' => $enddate,'start_time'=>$starttime,'end_time'=>$endtime]);
        return redirect('/');
    }
}
