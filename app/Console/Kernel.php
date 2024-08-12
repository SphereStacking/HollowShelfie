<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\GenerateMermaidERD::class,
        \App\Console\Commands\ImportScoutModels::class,

        /* 一時コマンド */
        // ファイル移行用のコマンド 1
        \App\Console\Commands\MigrateFiles\MigrateFilesStep1ToDefaultStorage::class,
        // ファイル移行用のコマンド 2
        \App\Console\Commands\MigrateFiles\MigrateFilesStep2DeleteLocal::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

