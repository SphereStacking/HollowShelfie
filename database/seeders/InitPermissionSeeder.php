<?php

namespace Database\Seeders;

use App\Models\Permission;

class InitPermissionSeeder extends AbstractOnceSeeder
{
    /**
     * Run the database seeds.
     */
    public function runOnce(): void
    {
        $InitPermissions = [
            ['name' => 'team-management', 'permission_denied_message' => '支援者の限定で試験解放中の機能になります。'],
        ];
        foreach ($InitPermissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'permission_denied_message' => $permission['permission_denied_message'],
            ]);
        }
    }
}
