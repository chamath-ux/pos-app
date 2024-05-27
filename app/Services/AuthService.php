<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * Get Authenticated user data
     * @return array
     */
    public function getAuthUser()
    {
        $success['token'] =  auth()->user()->createToken('MyApp',[''],now()->addWeek())->plainTextToken;
        $success['login_user'] =  Auth::user()->id;
        $success['user_role'] = auth()->user()->getRole();
        $success['rolePermissions']=$this->userRolePermissions();
        $success['userPermissions'] =$this->userPermissions();

        return $success;
    }

    /**
     * get the user assign role permissions
     *@return array
     */

    public function userRolePermissions()
    {
        $role= Role::with('rolePermissions')->find(auth()->user()->role_id);

        $permissions = $role->rolePermissions->map(function($per){
            return[
                'id'=>$per->id,
                'name'=>$per->name
            ];
        });

        return $permissions;
    }

    /**
    * get user permissions
    * @return array
     */

    public function userPermissions()
    {
        $permissionsList=User::with('permissions')->where('id',auth()->user()->id)->get();

       $permissions= $permissionsList->map(function($permission){
            $perm = [];
           foreach($permission->permissions as $per)
           {
                array_push($perm,['id'=>$per->id,'name' => $per->name]);
           }
               return $perm;
       });

       return $permissions;

    }
}
