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
        Schema::create('user', function (Blueprint $table) {
            $table->id(); // Auto-incrementing 'id' field as the primary key
            $table->string('username'); // Unique username
            $table->string('email')->unique(); // Unique email
            $table->string('password'); // Password
            $table->string('role')->default('user'); // User role
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
