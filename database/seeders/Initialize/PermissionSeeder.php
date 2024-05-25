<?php

namespace Database\Seeders\Initialize;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $InitPermissions = [
            [
                'name' => 'feature-team',
                'permission_denied_message' =>
                    '<p>この機能は現在、開発中です</p><p>🐙支援者(Patreon,Fanbox)に限定開放しています。</p>',
                'description' => 'チーム機能'
            ],
        ];
        foreach ($InitPermissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'permission_denied_message' => $permission['permission_denied_message'],
                'description' => $permission['description']
            ]);
        }
    }
}
