<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use App\Http\Controllers\BaseController;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\PermissionCollection;

class PermissionService extends BaseController
{
  /**
     * Assign a permission to the user.
     *
     * @param  string  $permissionName
     * @param integer $userId
     * @return void
     */
    public function givePermissionTo($userId,$permissionName)
    {
        try{

            $user = User::find($userId);

            $permission = Permission::where('name', $permissionName)->firstOrFail();
            $user->permissions()->syncWithoutDetaching([$permission->id]);

            return  successMessage('Permission add Successfully.');

        }catch(Exception $e)
        {
            Log::info('Error in givePermissionTo:'.$e->getMessage());
            return errorMessage($e->getMessage(),500);
        }

    }

    /**
     * Remove a permission to the user.
     *
     * @param  string  $permissionName
     * @param integer $userId
     * @return void
     */
    public function removePermissionFrom($userId,$permissionName)
    {
        try{

            $user = User::find($userId);

            $permission = Permission::where('name', $permissionName)->firstOrFail();
            $user->permissions()->detach($permission->id);

            return  successMessage('Permission remove Successfully.');

        }catch(Exception $e)
        {
            Log::info('Error in removePermissionFrom:'.$e->getMessage());
            return errorMessage($e->getMessage(),500);
        }

    }

       /**
     * Assign a permission to the role.
     *
     * @param  string  $permissionName
     * @param integer $roleId
     * @return void
     */
    public function permissionToRole($roleId,$permissionName)
    {
        try{
            $role = Role::find($roleId);

            $permission = Permission::where('name', $permissionName)->firstOrFail();
            $role->rolePermissions()->syncWithoutDetaching([$permission->id]);

            return  successMessage('Permission add Successfully.');

        }catch(Exception $e)
        {
            Log::info('Error in givePermissionToRole:'.$e->getMessage());
            return errorMessage($e->getMessage(),500);
        }

    }

    /**
     * Remove a permission to the role.
     *
     * @param  string  $permissionName
     * @param integer $roleId
     * @return void
     */
    public function removePermissionFromRole($roleId,$permissionName)
    {
        try{

            $role = Role::find($roleId);

            $permission = Permission::where('name', $permissionName)->firstOrFail();
            $role->rolePermissions()->detach($permission->id);

            return  successMessage('Permission remove Successfully.');

        }catch(Exception $e)
        {
            Log::info('Error in removePermissionFromRole:'.$e->getMessage());
            return errorMessage($e->getMessage(),500);
        }

    }


    /**
     * Get Permission list
     * @return array
     */

    public function getPermissionList($permission)
    {
        // dd($permission);
        return  successResponse(new PermissionCollection($permission->with(['users','roles'])->get()));
    }
}
