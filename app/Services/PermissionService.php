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

            return  $this->sendResponse('Permission add Successfully.');

        }catch(Exception $e)
        {
            Log::info('Error in givePermissionTo:'.$e->getMessage());
            return $this->sendError($e->getMessage(),'',500);
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

            return  $this->sendResponse('Permission add Successfully.');

        }catch(Exception $e)
        {
            Log::info('Error in removePermissionFrom:'.$e->getMessage());
            return $this->sendError($e->getMessage(),'',500);
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

            return  $this->sendResponse('Permission add Successfully.');

        }catch(Exception $e)
        {
            Log::info('Error in removePermissionFromRole:'.$e->getMessage());
            return $this->sendError($e->getMessage(),'',500);
        }

    }


    /**
     * Get Permission list
     * @return array
     */

    public function getPermissionList($permission)
    {
        dd($permission);
        return  $this->sendResponse(new PermissionResource($permission),'Permission add Successfully.');
        // $permissions= Permission::with(['users','roles'])->get();


        // $permissionList=$permissions->map(function($permission){

        //     $permissions['id'] = $permission->id;
        //     $permissions['name'] =$permission->name;
        //     $permissions['permittedUsers'] = $this->permittedUsers($permission->users);
        //     $permissions['permittedRoles'] = $this->permittedRoles($permission->roles);

        //     return $permissions;
        // });
        // return  $permissionList;
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
