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
            $table->unsignedBigInteger('workspace_id')->nullable()->after('user_id');

            // Define foreign key with "set null" behavior on delete
            $table->foreign('workspace_id')->references('id')->on('workspace')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->dropForeign(['workspace_id']);  // Drop the foreign key
            $table->dropColumn('workspace_id');  // Drop the user_id column
        });
    }
};
