<?php

namespace App\Console\Commands;

use App\Models\View;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class UpdateViewCounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:viewcounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update view counts from Redis';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $keys = Redis::keys('*:viewcount');
        $updates = [];
        foreach ($keys as $key) {
            // list($prefix, $viewable_type, $viewable_id, $countKey) = explode(':', $key);
            $value = Redis::get($key);
            Log::debug($key);
            Log::debug($value);
            // $view = View::where('viewable_type', $viewable_type)
            //     ->where('viewable_id', $viewable_id)
            //     ->first();
            // if ($view && $value) {
            //     $updates[] = [
            //         'id' => $view->id,
            //         'count' => $value
            //     ];
            // }
        }

        if (!empty($updates)) {
            foreach ($updates as $update) {
                View::where('id', $update['id'])->update(['count' => $update['count']]);
            }
        }

        // デバッグログを出力
        Log::debug('View counts updated', ['updates' => $updates]);
    }
}
