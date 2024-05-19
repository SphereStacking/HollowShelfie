<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        try {
            Permission::get()->map(function ($permission) {
                Gate::define($permission->name, function ($user) use ($permission) {
                    return $user->hasPermission($permission->name);
                });
            });
        } catch (\Exception $e) {
            Log::error(__FILE__ . " (" . __LINE__ . ")" . PHP_EOL . $e->getMessage());
            return;
        }

    }
}
