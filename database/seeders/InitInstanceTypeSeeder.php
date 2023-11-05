<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\InstanceType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InitInstanceTypeSeeder extends AbstractOnceSeeder
{
    /**
     * Run the database seeds.
     */
    public function runOnce(): void
    {
        $InitItems = [
            'リアル',
            'VRchat',
            'cluster',
            'Resonite',
        ];
        foreach ($InitItems as $item) {
            InstanceType::create(['name' => $item]);
        }
    }
}
