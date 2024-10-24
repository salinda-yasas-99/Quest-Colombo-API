<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->integer('points')->nullable()->after('status'); 
            $table->string('tier')->default('platinum')->after('points');
        });
    }

    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn('points');
            $table->dropColumn('tiar');
        });
    }
};
