<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

abstract class AbstractOnceSeeder extends Seeder
{
    abstract public function runOnce();

    public function run()
    {
        $className = get_class($this);

        $isSeeded = DB::table('seed_flags')->where('name', $className)->first();

        if ($isSeeded) {
            return;
        }

        $this->runOnce();

        DB::table('seed_flags')->insert(['name' => $className]);
    }
}
