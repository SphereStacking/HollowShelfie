<?php

namespace Database\Seeders\Initialize;

use App\Models\InstanceType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class InstanceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $InitItems = [
            ['name' => 'cluster', 'logo_path' => Storage::disk('public')->url('images/Logs/clusterlogo_2line_trans_color_dark.svg')],
            ['name' => 'Resonite', 'logo_path' => Storage::disk('public')->url('images/Logs/RSN_Logo_Color.svg')],
            ['name' => 'VRchat', 'logo_path' => Storage::disk('public')->url('images/Logs/VRChat_Logo.svg')],
            ['name' => '現実', 'logo_path' => Storage::disk('public')->url('images/Logs/reality.svg')],
            ['name' => 'other', 'logo_path' => Storage::disk('public')->url('images/Logs/other.svg')],
        ];
        foreach ($InitItems as $item) {
            InstanceType::create(['name' => $item['name'] , 'logo_path' => $item['logo_path']]);
        }
    }
}
