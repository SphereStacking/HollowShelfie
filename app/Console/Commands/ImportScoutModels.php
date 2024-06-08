<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ImportScoutModels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:import-all';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all scout models';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $models = [
            'App\\Models\\Event',
            'App\\Models\\User',
            'App\\Models\\Team',
            'App\\Models\\Tag',
        ];

        foreach ($models as $model) {
            $this->info("Importing scout model: $model");
            Artisan::call('scout:import', ['model' => $model]);
        }

        $this->info('All scout models have been imported successfully.');
    }
}
