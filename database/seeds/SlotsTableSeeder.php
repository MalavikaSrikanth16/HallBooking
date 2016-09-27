<?php

use Illuminate\Database\Seeder;
use App\slot as slot;

class SlotsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $times = array("08:00", "08:30", "09:00", "09:30", "10:00", "10:30", "11:00", "11:30", 
        				"12:00", "12:30", "13:00", "13:30", "14:00", "14:30","15:00", "15:30", 
        				"16:00", "16:30", "17:00", "17:30", "18:00", "18:30", "19:00", "19:30");

        for($i=0;$i<24;$i++)
        {
        	$slot = new slot;
        	$slot->start_time = $times[$i];
        	$slot->save();
        }
    }
}
