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
        Schema::table('workspace_slot', function (Blueprint $table) {
             // Add the workspace_id column to the workspace_slot table
             $table->unsignedBigInteger('workspace_id')->after('slot_3');

             // Define the foreign key constraint
             $table->foreign('workspace_id')->references('id')->on('workspace')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workspace_slot', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['workspace_id']);

            // Remove the workspace_id column
            $table->dropColumn('workspace_id');
        });
    }
};
