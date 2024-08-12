<?php

namespace App\Console\Commands\MigrateFiles;

use App\Models\File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * ファイル移行 - Step1 - サーバーのローカルに保存されたファイルを
 * R2ストレージに移動する。
 */
class MigrateFilesStep1ToDefaultStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate-files:step1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ファイル移行 - Step1: Migrate all files from public storage to the default storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $publicDisk = Storage::disk('public');
        $defaultDisk = Storage::disk(config('filesystems.default'));

        File::chunk(50, function ($files) use ($publicDisk, $defaultDisk) {
            foreach ($files as $file) {
                if ($publicDisk->exists($file->path . '/' . $file->name)) {
                    $fileContents = $publicDisk->get($file->path . '/' . $file->name);
                    $defaultDisk->put($file->path . '/' . $file->name, $fileContents);
                    $this->info("Migrating: {$file->path}/{$file->name}");
                } else {
                    $this->warn("File not found: {$file->path}/{$file->name}");
                }
            };
        });
        $this->info('All files have been migrated to the default storage.');
    }
}
