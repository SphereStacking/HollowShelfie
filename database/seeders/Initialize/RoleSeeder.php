<?php

namespace Database\Seeders\Initialize;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $InitRoles = [
            ['name' => 'admin', 'description' => 'システム全体の管理者'],
            ['name' => 'moderator', 'description' => 'コンテンツやユーザーの管理を行う'],
            ['name' => 'standard', 'description' => 'スタンダードプラン契約者'],
            ['name' => 'premium', 'description' => 'プレミアムプラン契約者'],
            ['name' => 'beta_tester', 'description' => 'リリース前の機能を先行体験するユーザー'],
            ['name' => 'early_supporter', 'description' => '早期に支援してくれたユーザー'],
        ];
        foreach ($InitRoles as $role) {
            Role::create(['name' => $role['name'], 'description' => $role['description']]);
        }
    }
}
