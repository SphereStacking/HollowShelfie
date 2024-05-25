<?php

namespace Database\Seeders\Initialize;

use App\Models\InstanceType;
use Illuminate\Database\Seeder;

class InstanceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $InitItems = [
            '現実',
            'VRchat',
            'cluster',
            'Resonite',
        ];
        foreach ($InitItems as $item) {
            InstanceType::create(['name' => $item]);
        }
    }
}
