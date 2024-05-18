<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ChangePermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;
    use ChangePermissions;

    protected $fillable = [
        'name',
    ];

    /**
     * ユーザーとのリレーション
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * 権限とのリレーション
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasPermission(String $permission)
    {
        $this->load('permissions.roles');
        foreach ($this->permissions as $permission) {
            if ($permission->roles->contains('name', $permission)) {
                return true;
            }
        }
    }
}
