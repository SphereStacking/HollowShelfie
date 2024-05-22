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
        Schema::create('time_table_performers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('event_time_table_id')->constrained()->cascadeOnDelete();
            $table->morphs('performable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_table_performers');
    }
};
