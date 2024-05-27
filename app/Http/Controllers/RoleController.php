<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\PermissionService;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;

class RoleController extends BaseController
{
    public function create(Request $request)
    {
        try{

            $role= Role::create($request->all());
            return $this->sendResponse($role, 'Created Role Successfully.');

            }catch(InvalidTokenException $e){

                Log::info('Error in RoleController create:'.$e);
                return $this->sendError('Token not valid','',500);

            }catch(Exception $e)
            {
                Log::info('Error in RoleController create:'.$e->getMessage());
                return $this->sendError($e->getMessage(),'',500);
            }

    }

    public function assignPermissionToUser(Request $request)
    {
        try{

            $role= User::find($request->userId);
            $role->role_id = $request->roleId;
            $role->save();
            return $this->sendResponse($role, 'Successfully.Updated');

            }catch(InvalidTokenException $e){

                Log::info('Error in RoleController create:'.$e);
                return $this->sendError('Token not valid','',500);

            }catch(Exception $e)
            {
                Log::info('Error in RoleController create:'.$e->getMessage());
                return $this->sendError($e->getMessage(),'',500);
            }
    }

    public function deleteRole(Request $request)
    {
        try{

            if(!Role::destroy($request->roleId))
            {
                throw new Exception('Error on deleting Role');
            }


            $role =Role::destroy($request->roleId);
            dd($role);
            return $this->sendResponse($role, 'Successfully.Updated');

        }catch(InvalidTokenException $e){

            Log::info('Error in RoleController create:'.$e);
            return $this->sendError('Token not valid','',500);

        }catch(Exception $e)
        {
            Log::info('Error in RoleController create:'.$e->getMessage());
            return $this->sendError($e->getMessage(),'',500);
        }
    }
}
