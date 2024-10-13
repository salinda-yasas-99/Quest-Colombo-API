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
         // Add 'stripe_charge_id' to the 'bookings' table
         Schema::table('booking', function (Blueprint $table) {
            $table->string('stripeChargeId')->nullable()->after('endTime'); // Adjust as necessary
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->dropColumn('stripeChargeId');
        });
    }
};
