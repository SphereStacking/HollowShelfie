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
        Schema::create('instances', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('instance_type_id')->nullable();
            $table->text('access_url', 2048)->nullable()->comment('アクセスURL');
            $table->text('display_name')->nullable()->comment('表示名');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instances');
    }
};
