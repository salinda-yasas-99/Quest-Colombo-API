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
            $table->decimal('fee', 8, 2)->after('location'); // Add the fee column after location
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workspace', function (Blueprint $table) {
            $table->dropColumn('fee');
        });
    }
};
