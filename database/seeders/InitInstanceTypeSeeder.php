<?php

namespace Database\Seeders;

use App\Models\InstanceType;

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
