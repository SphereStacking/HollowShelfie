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
        Schema::table('event_time_tables', function (Blueprint $table) {
            $table->foreignId('event_date_id')->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_time_tables', function (Blueprint $table) {
            if (Schema::hasColumn('event_time_tables', 'event_date_id')) {
                $table->dropForeign(['event_date_id']);
                $table->dropColumn('event_date_id');
            }
        });
    }
};
