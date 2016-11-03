<?php

namespace App\Http\Controllers;

use App\hall;
use App\bookedSlot;
use App\adminbooking;
use App\User;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Carbon\Carbon;

class AdminRow
{
    public $startDate, $endDate, $hallName, $slotStartTime, $slotEndTime, $bookingId;
}

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
        
        $location = DB::table('halls')->where('id', $hallid)->value('location');
        $halls = hall::all()->where('location', $location);
    	$user = Auth::user()->name; //As of now only 'admin' 
    	
        $startdate = $request->input('startDate');    	
    	$enddate = $request->input('endDate');
    	
        $starttime = $request->input('startTime');
    	$endtime = $request->input('endTime');

        $bookingStartDate = strtotime($startdate);
        $bookingEndDate = strtotime($enddate);

        $bookingStartTime = strtotime($starttime);
        $bookingEndTime = strtotime($endtime);

        $currentDate = strtotime(Carbon::now()->format('d-m-Y'));

        // dd (($bookingEndTime-$bookingStartTime)/3600);
        // dd((($bookingDate-$currentDate)/86400));
        // if((($bookingStartDate-$currentDate)/86400)>=3 && (($bookingEndDate-$bookingStartDate)/86400)>=0)
        
        if((($bookingStartDate-$currentDate)/86400)<3)
        {
            return view('adminHalls', compact('halls', 'location'))->with('message', 'Halls must be booked at least three days prior. Please change the start date.');
        }
        else
        if ((($bookingEndDate-$bookingStartDate)/86400)<0) 
        {
            return view('adminHalls', compact('halls', 'location'))->with('message', 'Start date must preceed end date. Please enter valid start and end dates.');
        }
        else
        if ((($bookingEndTime-$bookingStartTime)/3600)<=0) 
        {
            return view('adminHalls', compact('halls', 'location'))->with('message', 'Start time must preceed end time. Please enter valid start and end times.');
        }
        else
        {
        	DB::table('adminbookings')->insert(['hall_booked' => $hallid, 'admin_username' => $user, 'start_date'=> $startdate, 'end_date' => $enddate,'start_time'=>$starttime,'end_time'=>$endtime]);
            return redirect('/admin/myHalls');
        }
        
    }


    public function myHalls()
    {   
        // utility map to display slot start time in the view rather than slot id for clarity

        $slotMap = array("08:00", "08:30", "09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", 
                "13:30", "14:00", "14:30","15:00", "15:30", "16:00", "16:30", "17:00", "17:30", "18:00", "18:30", "19:00", "19:30");

        $tableRows = array();

        $userName = Auth::user()->name;

        // $userMail = DB::table('users')->where('name', $userName)->value('email');
        // dd($userMail);

        //get all bookings of the authorized user based on mail
        $bookings = adminbooking::all()->where('admin_username', $userName);


        //populate relevant data into tableRows to be passed to views
        foreach ($bookings as $book) {
                

            $bookId = $book["id"];
            $hallBookedId = $book["hall_booked"];
            $startDate = $book["start_date"];
            $endDate = $book["end_date"];
            $startTime = $book["start_time"];
            $endTime = $book["end_time"];

            $hallName = DB::table('halls')->where('id', $hallBookedId)->value('name');

            // $slots = DB::table("booked_slots")->where('booking_id', $bookId)->get();


            $row = new AdminRow();

            $row->hallName = $hallName;
            $row->startDate =  $startDate;
            $row->endDate =  $endDate;
            $row->startTime =  $startTime;
            $row->endTime =  $endTime;
            $row->bookingId = $bookId;
            // $row->slots = $slots;

            // append object into array
            $tableRows[] = $row;

 

        }

        //print_r($tableRows);


        return view('myHalls.myHallsAdmin')->with('data',$tableRows);
    }


    public function cancelHalls(Request $request)
    {
        //print_r($request->input('bookIds'));

        // delete from the booked_slots table first and then from the bookings table
        foreach($request->input('bookIds') as $bookId) {
            DB::table('booked_slots')->where('booking_id', $bookId)->delete();
            DB::table('adminbookings')->where('id', $bookId)->delete();
        }


        return redirect('/admin/myHalls');

    }
}
