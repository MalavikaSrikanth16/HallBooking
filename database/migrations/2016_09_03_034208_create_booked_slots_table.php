<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookedSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booked_slots', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id');
            $table->integer('slot_id');
            $table->foreign('booking_id')->references('id')->on('booking');
            $table->foreign('slot_id')->references('id')->on('slots');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('booked_slots');
    }
}
