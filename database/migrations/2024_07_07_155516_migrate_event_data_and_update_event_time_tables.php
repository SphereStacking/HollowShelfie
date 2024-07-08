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
        $this->migrateExistingData();

        Schema::table('event_time_tables', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id');
            $table->foreignId('event_date_id')->change()->constrained()->cascadeOnDelete();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('events', function (Blueprint $table) {
            $table->timestamp('start_date')->nullable()->after('description');
            $table->timestamp('end_date')->nullable()->after('start_date');
        });

        Schema::table('event_time_tables', function (Blueprint $table) {
            $table->foreignId('event_id')->after('id')->nullable();
        });

        $this->revertDataMigration();

        Schema::table('event_time_tables', function (Blueprint $table) {
            $table->foreignId('event_id')->change()->constrained()->cascadeOnDelete();
            $table->dropForeign(['event_date_id']);
            $table->dropColumn('event_date_id');
        });
    }

    private function migrateExistingData(): void
    {
        DB::transaction(function () {
            DB::table('event_time_tables')
                ->orderBy('id')
                ->chunk(100, function ($timeTables) {
                    foreach ($timeTables as $timeTable) {
                        try {
                            $eventDateId = DB::table('event_dates')->insertGetId([
                                'event_id' => $timeTable->event_id,
                                'start_date' => $timeTable->start_date,
                                'end_date' => $timeTable->end_date,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                            DB::table('event_time_tables')
                                ->where('id', $timeTable->id)
                                ->update(['event_date_id' => $eventDateId]);
                        } catch (\Exception $e) {
                            Log::error("Error migrating event_time_table ID: {$timeTable->id}. Error: " . $e->getMessage());
                            throw $e;
                        }
                    }
                });
        });
    }

    private function revertDataMigration(): void
    {
        DB::transaction(function () {
            // event_time_tablesの復元
            DB::table('event_time_tables')
                ->orderBy('id')
                ->chunk(100, function ($timeTables) {
                    foreach ($timeTables as $timeTable) {
                        try {
                            $eventDate = DB::table('event_dates')
                                ->where('id', $timeTable->event_date_id)
                                ->first();

                            if ($eventDate) {
                                DB::table('event_time_tables')
                                    ->where('id', $timeTable->id)
                                    ->update([
                                        'event_id' => $eventDate->event_id,
                                        'start_date' => $eventDate->start_date,
                                        'end_date' => $eventDate->end_date,
                                    ]);

                                // eventsテーブルのstart_dateとend_dateを更新
                                DB::table('events')
                                    ->where('id', $eventDate->event_id)
                                    ->update([
                                        'start_date' => DB::raw("LEAST(COALESCE(start_date, '{$eventDate->start_date}'), '{$eventDate->start_date}')"),
                                        'end_date' => DB::raw("GREATEST(COALESCE(end_date, '{$eventDate->end_date}'), '{$eventDate->end_date}')"),
                                    ]);

                            } else {
                                Log::warning("No matching event_date found for event_time_table ID: {$timeTable->id}");
                            }
                        } catch (\Exception $e) {
                            Log::error("Error reverting event_time_table ID: {$timeTable->id}. Error: " . $e->getMessage());
                            throw $e;
                        }
                    }
                });

            // event_time_tablesからevent_date_idを削除
            DB::table('event_time_tables')->update(['event_date_id' => null]);

            // event_datesテーブルを空にする
            DB::table('event_dates')->delete();
        });
    }
};

