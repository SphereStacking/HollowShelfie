<?php

namespace Database\Seeders;

use App\Models\Role;

class InitRoleSeeder extends AbstractOnceSeeder
{
    /**
     * Run the database seeds.
     */
    public function runOnce(): void
    {
        $InitRoles = [
            ['name' => 'admin', 'description' => 'システム全体の管理者'],
            ['name' => 'moderator', 'description' => 'コンテンツやユーザーの管理を行う'],
            ['name' => 'tester', 'description' => '試験的機能を'],
            ['name' => 'standard', 'description' => 'スタンダードプラン契約者'],
            ['name' => 'premium', 'description' => 'プレミアムプラン契約者'],
        ];
        foreach ($InitRoles as $role) {
            Role::create(['name' => $role['name'], 'description' => $role['description']]);
        }
    }
}
