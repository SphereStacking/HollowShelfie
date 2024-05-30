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
        Schema::create('screen_names', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->morphs('screen_nameable');
            $table->string('screen_name',14)->unique()->comment('公開表示名');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screen_names');
    }
};
