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
        Schema::create('custom_identifiables', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('screen_name');
            $table->morphs('identifiable');
            $table->unique(['screen_name', 'identifiable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_identifiables');
    }
};
