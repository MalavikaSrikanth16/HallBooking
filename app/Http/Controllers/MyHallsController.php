<?php

namespace App\Http\Controllers;

use App\hall;
use App\bookedSlot;
use App\booking;
use App\User;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

class Row
{
	public $date, $hallName, $slotStartTime, $bookingId, $slots;
}

class MyHallsController extends Controller
{
    //

    public function myHalls()
    {	
    	// utility map to display slot start time in the view rather than slot id for clarity

    	$slotMap = array("08:00", "08:30", "09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", 
    			"13:30", "14:00", "14:30","15:00", "15:30", "16:00", "16:30", "17:00", "17:30", "18:00", "18:30", "19:00", "19:30");

    	$tableRows = array();

        // $userMail = Auth::user()->email;
    	$userMail = session()->get('email');

    	//get all bookings of the authorized user based on mail
    	$bookings = booking::all()->where('webmail_id', $userMail);


    	//populate relevant data into tableRows to be passed to views
    	foreach ($bookings as $book) {
    			

    		$bookId = $book["id"];
    		$hallBookedId = $book["hall_booked"];
    		$bookDate = $book["date"];

    		$hallName = DB::table('halls')->where('id', $hallBookedId)->value('name');

    		$slots = DB::table("booked_slots")->where('booking_id', $bookId)->get();


    		$row = new Row();

    		$row->hallName = $hallName;
    		$row->date =  $bookDate;
    		$row->bookingId = $bookId;
    		$row->slots = $slots;

    		// append object into array
    		$tableRows[] = $row;

 

    	}

    	//print_r($tableRows);


    	return view('myHalls.myHallsHome', compact('slotMap'))->with('data',$tableRows);
    }


    public function cancelHalls(Request $request)
    {

    	//print_r($request->input('bookIds'));

        // delete from the booked_slots table first and then from the bookings table
        foreach($request->input('bookIds') as $bookId) {
            DB::table('booked_slots')->where('booking_id', $bookId)->delete();
            DB::table('booking')->where('id', $bookId)->delete();
        }


        return redirect()->action('MyHallsController@myHalls');


    }

}
