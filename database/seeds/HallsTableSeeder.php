<?php

use Illuminate\Database\Seeder;
use App\hall as hall;

class HallsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$halls = array(array("CS301", "CSE"), 
    				array("CS302", "CSE"),
    				array("LH101", "LHC"),
    				array("LH102", "LHC"),
    				array("NG01", "Orion"),
    				array("NG02", "Orion"));
        
        for($i=0;$i<count($halls);$i++)
        {
        	$hall = new hall;
        	$hall->name = $halls[$i][0];
        	$hall->location = $halls[$i][1];
        	$hall->save();
        }
    }
}
