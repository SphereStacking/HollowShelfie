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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->integer('user_id');
            $table->integer('organizer_id');
            $table->string('location');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('description');
            $table->string('status')->default(\App\Enums\EventStatus::DRAFT);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
