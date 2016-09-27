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
use Carbon\Carbon;

class BookingController extends Controller
{
    //

    public function book()
    {
    	return view('booking.book');
    }

    public function getHalls(Request $request)
    {
    	$location = $request->input('location');
    	$date = $request->input('bookDate');

        $bookingDate = strtotime($date);
        $currentDate = strtotime(Carbon::now()->format('d-m-Y'));
        // echo $bookingDate."<br>".$currenDate."<br>";

        // dd((($bookingDate-$currentDate)/86400));
        if((($bookingDate-$currentDate)/86400)<=3)
        {
        	$halls = hall::all()->where('location', $location);
                

        	foreach($halls as $hall){
        		//echo $hall->name;

        		// initially populate all slots as available
        		$times[$hall->name] = array("08:00", "08:30", "09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", 
        			"13:30", "14:00", "14:30","15:00", "15:30", "16:00", "16:30", "17:00", "17:30", "18:00", "18:30", "19:00", "19:30");

        		// get the hall id given the hall name
        		$hallId = DB::table('halls')->where('name', $hall->name)->value('id');

            // filter based on slots booked by the admin
                
                // get start_time and end_time where start date < booking date < end date
                $adminBooking = DB::table('adminbookings')->select('start_time', 'end_time')->where([ ['start_date' ,'<=', $date], ['end_date', '>=', $date] ])->get();

                // get slot ids of all slots within the above range
                $startSlot = DB::table('slots')->where('start_time', gmdate("H:i", strtotime($adminBooking[0]->start_time)))->value('id');

                $endSlot = DB::table('slots')->where('start_time', gmdate("H:i", strtotime($adminBooking[0]->end_time)))->value('id');

                for($i=$startSlot;$i<=$endSlot;$i++)
                    $bookedSlots[$i-$startSlot]=$i;
                
            // filter based on slots booked by other faculty 

                // get booking id from the booking table if the same hall has been booked by someone else on this date
                $bookingId = DB::table('booking')->where([ ['date', $date], ['hall_booked', $hallId] ])->value('id');

                // get the slots booked for this booking id. bookedSlots is an array of all booked slots
                $facultyBookedSlots = DB::table('booked_slots')->select('slot_id')->where('booking_id', $bookingId)->get();

                // combined array of all booked slots

                foreach($facultyBookedSlots as $slot)
                    array_push($bookedSlots, $slot->slot_id);
                // dd($bookedSlots);

                // for each slot which has been booked (by both admin and faculty), remove it from the times[$hall->name] array so that it isnt displayed in the view
        		foreach($bookedSlots as $slotId){

        			// get slot time for corresponding slotid
        			$startTime = DB::table('slots')->where('id', $slotId)->value('start_time');

        			// remove those slot times from the times array which have been booked 
        			if (($key = array_search($startTime, $times[$hall->name])) !== false) {
        				unset($times[$hall->name][$key]);
    				}

    				$times[$hall->name] = array_values($times[$hall->name]);
        		}

        	}


        	//return $times;
        	return view('booking.bookHalls', compact('halls', 'location', 'times', 'date'));
        }

        else
        {
            return view('booking.book');
        }

    }


    public function bookHalls(Request $request)
    {

    	$slots = $request->input('slot');
    	$date = $request->input('date');
    	$user = Auth::user()->name;
    	$mail = Auth::user()->email;

    	// each slot is of the format 'LH01,17:00'
    	// suppose the prof bookes from 5pm-6pm on the given date in 2 halls LH01 and LH02
    	// at the end of this for loop, booking table will contain 2 rows one corresponding to each hall

    	foreach($slots as $slot){

    		$temp = explode(',',$slot);
    		$hall = $temp[0];
    		$time = $temp[1];

    		// get the hallid of the hall from the halls table
    		$hallId = DB::table('halls')->where('name', $hall)->value('id');

    		// problem occurs when user tries to book multiple halls in one booking. (Multiple entries go into booking table)
    		// so in this model one can book one hall in one booking

    		// to make sure there arent multiple entries for the same hall for the same day
    		// booking table will contain date, hallid, prof details.
    		// slot details will be there in the booked_slots table seperately

    		if(!DB::table('booking')->where([ ['hall_booked','=', $hallId], ['date', '=', $date] ])->value('id'))
    		{
    			DB::table('booking')->insert(['date' => $date, 'hall_booked' => $hallId, 'prof_name' => $user, 'webmail_id' => $mail]);
    		}

    		//DB::table('booking')->where('hall_booked', $hallId)->value('id');
    		
    	}

    	// at the end of this for loop booked slots will contain the records {1, 19(19 is slot id for 5-530)} and {1, 20(20 is slot id for 530-6)}
    	// where 1 is the booking id of this booking obtained based on hall_booked

    	foreach($slots as $slot){
    		$temp = explode(',',$slot);
    		$hall = $temp[0];
    		$time = $temp[1];

    		//get the hallid of the hall from the halls table 
    		$hallId = DB::table('halls')->where('name', $hall)->value('id');

    		// get booking id for this booking
    		$bookingId = DB::table('booking')->where([ ['hall_booked', $hallId], ['date', $date] ])->value('id');

    		// get slot id from the slots table given the slot start time
    		$slotId = DB::table('slots')->where('start_time', $time)->value('id');

    		// add record to the booked_slots table
    		DB::table('booked_slots')->insert(['booking_id' => $bookingId, 'slot_id' => $slotId]);

    		//echo $bookingId . ' '. $slotId;
    	}

    	return redirect('/myhalls');
    }
}
