<?php

namespace App\Models\Traits;

use App\Models\Permission;

trait ChangePermissions
{
    /**
     * 権限の付与
     */
    public function givePermissions(array $permissions): self
    {
        $permissions = $this->getPermissions($permissions);
        if ($permissions->isEmpty()) return $this;

        foreach ($permissions as $perm) {
            if (!$this->hasPermission($perm->name)) {
                $this->permissions()->attach($perm->id);
            }
        }
        return $this;
    }

    /**
     * 権限の剥奪
     */
    public function removePermissions(array $permissions): self
    {
        $permissions = $this->getPermissions($permissions);
	if ($permissions->isEmpty()) return $this;

        foreach ($permissions as $perm) {
            if ($this->hasPermission($perm->name)) {
                $this->permissions()->detach($perm->id);
            }
        }
        return $this;
    }

    /**
     * 権限の更新
     */
    public function refreshPermissions(array $permissions): self
    {
        $this->permissions()->detach();
        return $this->givePermissions($permissions);
    }

    /**
     * 権限の取得
     */
    protected function getPermissions(array $permissions): Collection
    {
        return Permission::whereIn('name', $permissions)->get();
    }
}
