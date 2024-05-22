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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('path')->comment('パス');
            $table->string('name')->comment('名前');
            $table->string('original_name')->comment('元名');
            $table->string('type')->comment('種類');
            $table->unsignedBigInteger('fileable_id')->comment('モデルのID');
            $table->string('fileable_type')->comment('モデルの種類');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
