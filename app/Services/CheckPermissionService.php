<?php
namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;

class CheckPermissionService
 {
        /**
     * Check if the user has a specific permission.
     *
     * @param  string  $permissionName
     * @return bool
     */
    public function hasPermission($permissionName)
    {
        $user = User::find(auth()->user()->id);
        $role= Role::find(auth()->user()->role_id);

        if($role === null){ return false; }

        return $user->admin() || $user->permissions()->where('name', $permissionName)->exists() || $role->rolePermissions()->where('name', $permissionName)->exists();
    }
 }
