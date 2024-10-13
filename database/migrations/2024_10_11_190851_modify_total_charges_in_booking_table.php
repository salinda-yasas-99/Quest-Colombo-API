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
        Schema::table('booking', function (Blueprint $table) {
            Schema::table('booking', function (Blueprint $table) {
                // Modify totalCharges column to decimal with precision (8, 2)
                $table->decimal('totalCharges', 8, 2)->change();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            // Optionally, revert the totalCharges column back to string if needed
            $table->string('totalCharges')->change();
        });
    }
};
