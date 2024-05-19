<?php

namespace App\Models\Traits;

use App\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * ユーザー関連のトレイト
 */
trait UserRole
{
    /**
     * ロールとのリレーション
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * ロールを持っているか
     */
    public function hasRole(String|int $role): bool
    {
        return $this->roles()
            ->where('name', $role)
            ->orWhere('id', $role)
            ->exists();
    }

    /**
     * 権限を持っているか
     */
    public function hasPermission(String $permission): bool
    {
        $this->load('roles.permissions');
        foreach ($this->roles as $role) {
            if ($role->permissions->contains('name', $permission)) {
                return true;
            }
        }
        return false;
    }



}
