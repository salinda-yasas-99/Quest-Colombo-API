<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->string('totalCharges');
            $table->date('bookedDate');
            $table->time('bookedTime');
            $table->string('paymentMethod');
            $table->string('paymentStatus');
            $table->string('bookedSlot'); 
            $table->time('startTime');
            $table->time('endTime');

           
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
