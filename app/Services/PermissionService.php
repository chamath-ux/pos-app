<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;

class PermissionService
{
  /**
     * Assign a permission to the user.
     *
     * @param  string  $permissionName
     * @param integer $userId
     * @return void
     */
    public static function givePermissionTo($userId,$permissionName)
    {
        $user = User::find($userId);

        $permission = Permission::where('name', $permissionName)->firstOrFail();
        $user->permissions()->syncWithoutDetaching([$permission->id]);
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
        $user = User::find($userId);

        $permission = Permission::where('name', $permissionName)->firstOrFail();
        $user->permissions()->detach($permission->id);
    }

       /**
     * Assign a permission to the role.
     *
     * @param  string  $permissionName
     * @param integer $roleId
     * @return void
     */
    public static function givePermissionToRole($roleId,$permissionName)
    {
        $role = Role::find($roleId);

        $permission = Permission::where('name', $permissionName)->firstOrFail();
        $role->rolePermissions()->syncWithoutDetaching([$permission->id]);
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
        $role = Role::find($roleId);

        $permission = Permission::where('name', $permissionName)->firstOrFail();
        $role->rolePermissions()->detach($permission->id);
    }


    /**
     * Get Permission list
     * @return array
     */

    public function getPermissionList()
    {
        $permissions= Permission::with(['users','roles'])->get();


        $permissionList=$permissions->map(function($permission){

            $permissions['id'] = $permission->id;
            $permissions['name'] =$permission->name;
            $permissions['permittedUsers'] = $this->permittedUsers($permission->users);
            $permissions['permittedRoles'] = $this->permittedRoles($permission->roles);

            return $permissions;
        });
        return  $permissionList;
    }

    /**
     * Get permitted user list
     * @return array
     */

    public function permittedUsers($permission)
    {
        $permissions = $permission->map(function($user){
            return [
                    'id'=>$user->id,
                    'name'=>$user->getFullNameAttribute(),
                    'email'=>$user->email
                    ];
        });

        return $permissions;
    }

    /**
     *
     * Get Permitted Roles List
     * @return array
     */

    public function permittedRoles($permission)
    {
        $permissions= $permission->map(function($role){
            return[
                'id'=>$role->id,
                'name'=>$role->name
            ];
        });

        return $permissions;
    }
}
