<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Permission;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $permissionRecord = Permission::where('name', $permission)->first();
        if (!$permissionRecord) {
            abort(500, '権限が見つかりません。');
        }
        if (!$request->user()->can($permission)) {
            abort(403, $permissionRecord->permission_denied_message ?? '');
        }

        return $next($request);
    }
}
