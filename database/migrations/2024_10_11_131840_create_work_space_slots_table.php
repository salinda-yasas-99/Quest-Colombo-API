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
        Schema::create('workspace_slot', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('slot_1');
            $table->string('slot_2');
            $table->string('slot_3');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workspace_slot');
    }
};
