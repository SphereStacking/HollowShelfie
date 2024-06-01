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
            $table->softDeletes();
            $table->timestamp('published_at')->nullable()->comment('公開日時');
            $table->boolean('is_forced_hidden')->default(false)->comment('強制非表示フラグ');
            $table->text('title')->comment('タイトル');
            $table->unsignedBigInteger('created_user_id')->comment('イベント作成者ID');
            $table->timestamp('start_date')->nullable()->comment('開始日時');
            $table->timestamp('end_date')->nullable()->comment('終了日時');
            $table->text('description')->comment('説明');
            $table->string('alias')->unique()->comment('エイリアス');
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
