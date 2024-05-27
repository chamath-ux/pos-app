<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Services\PermissionService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;

class PermissionController extends BaseController
{
    public function givePermission(Request $request ,PermissionService $permission)
    {
        try{

            $permission->givePermissionTo($request->userId,$request->permission);
            $success['permission'] = $request->permission;
            $success['user'] = $request->userId;

            return $this->sendResponse($success, 'SuccessFully give the permission');

        }catch(InvalidTokenException $e){

            Log::info('Error in PermissionController givePermission:'.$e);
            return $this->sendError('Token not valid','',500);

        }catch(Exception $e)
        {
            Log::info('Error in PermissionController givePermission:'.$e);
            return $this->sendError($e->getMessage(),'',500);
        }

    }

    public function removePermission(Request $request ,PermissionService $permission)
    {
        try{

            $permission->removePermissionFrom($request->userId,$request->permission);

            return $this->sendResponse('','SuccessFully remove the permission');

        }catch(InvalidTokenException $e){

            Log::info('Error in PermissionController removePermission:'.$e);
            return $this->sendError('Token not valid','',500);

        }catch(Exception $e)
        {
            Log::info('Error in PermissionController removePermission:'.$e);
            return $this->sendError($e->getMessage(),'',500);
        }

    }

    public function givePermissionToRole(Request $request ,PermissionService $permission)
    {
        try{

            $permission->givePermissionToRole($request->roleId,$request->permission);
            $success['permission'] = $request->permission;
            $success['role'] = $request->roleId;

            return $this->sendResponse($success, 'SuccessFully give the permission');

        }catch(InvalidTokenException $e){

            Log::info('Error in PermissionController givePermissionToRole:'.$e);
            return $this->sendError('Token not valid','',500);

        }catch(Exception $e)
        {
            Log::info('Error in PermissionController givePermissionToRole:'.$e);
            return $this->sendError($e->getMessage(),'',500);
        }
    }

    public function getAllPermissions(PermissionService $permission)
    {
        try{

            $permissionList = $permission->getPermissionList();

            return $this->sendResponse($permissionList,'The permission list');

        }catch(InvalidException $e)
        {
            Log::info('Error in PermissionController getAllPermissions:'.$e);
            return $this->sendError('Token not valid','',500);

        }catch(Exception $e)
        {
            Log::info('Error in PermissionController getAllPermissions:'.$e);
            return $this->sendError($e->getMessage(),'',500);
        }
    }
}
