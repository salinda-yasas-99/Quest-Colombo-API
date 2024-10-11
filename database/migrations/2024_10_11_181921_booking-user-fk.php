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
            // Add a nullable foreign key to the user table
            $table->unsignedBigInteger('user_id')->nullable()->after('endTime');;

            // Define foreign key with "set null" behavior on delete
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->dropForeign(['user_id']);  // Drop the foreign key
            $table->dropColumn('user_id');  // Drop the user_id column
        });
    }
};
