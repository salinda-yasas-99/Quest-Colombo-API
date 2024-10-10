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
        Schema::table('workspace', function (Blueprint $table) {
            $table->unsignedBigInteger('workspace_type_id');  // Add foreign key column

            // Define the foreign key constraint
            $table->foreign('workspace_type_id')->references('id')->on('workspace_type')->onDelete('cascade');
        });
    }

    /**
     * Reverse th
     * e migrations.
     */
    public function down(): void
    {
        Schema::table('workspace', function (Blueprint $table) {
            $table->dropForeign(['workspace_type_id']);  // Drop foreign key constraint
            $table->dropColumn('workspace_type_id');      // Drop column
        });
    }
};
