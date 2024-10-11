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
            // Add package_id as a nullable foreign key to the package table
            $table->unsignedBigInteger('package_id')->nullable()->after('workspace_id');  

            // Define foreign key with "set null" behavior on delete
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('set null');
        });
    }

   
    public function down(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            // Drop foreign key and column if the migration is rolled back
            $table->dropForeign(['package_id']);
            $table->dropColumn('package_id');
        });
    }
};
