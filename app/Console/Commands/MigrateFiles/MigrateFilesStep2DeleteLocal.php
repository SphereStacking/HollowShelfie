<?php

namespace App\Console\Commands\MigrateFiles;

use App\Models\File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * ファイル移行 - Step2 - R2ストレージに移動されたファイルを
 * サーバーのローカルから削除する。
 */
class MigrateFilesStep2DeleteLocal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate-files:step2-delete-local';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ファイル移行 - Step2: Delete all migrated files from local public storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->confirm('ローカルのパブリックストレージから移行済みのすべてのファイルを削除してもよろしいですか？')) {
            $this->info('操作がキャンセルされました。');
            return;
        }

        $publicDisk = Storage::disk('public');
        $defaultDisk = Storage::disk(config('filesystems.default'));

        File::chunk(50, function ($files) use ($publicDisk, $defaultDisk) {
            foreach ($files as $file) {
                if ($defaultDisk->exists($file->path) && $publicDisk->exists($file->path . '/' . $file->filename)) {
                    $publicDisk->delete($file->path . '/' . $file->filename);
                    $this->info("Deleted local file: {$file->path} / {$file->filename}");
                } else {
                    $this->warn("File not found in local or not migrated: {$file->path} / {$file->filename}");
                }
            };
        });
        $this->info('All migrated files have been deleted from local public storage.');
    }
}
