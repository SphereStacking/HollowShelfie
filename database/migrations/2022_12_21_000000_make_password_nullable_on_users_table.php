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
        // NOTE: socialstreamの追加されたファイル
        //       2014_10_12_000000_create_users_tableで
        //       既にpasswordカラムはnullableに設定されている
        //       そのためこちらはコメントアウト

        // Schema::table('users', function (Blueprint $table) {
        //     $table->string('password')->nullable()->change();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('users', function (Blueprint $table) {
        //     $table->string('password')->nullable(false)->change();
        // });
    }
};
