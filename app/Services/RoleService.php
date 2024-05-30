<?php

namespace App\Services;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\UserCollection;

class RoleService
{
    public function create($request)
    {
        try{

            $role= Role::create($request->all());
            return successMessage('Created Role Successfully.',200);

            }catch(InvalidTokenException $e){

                Log::info('Error in RoleController create:'.$e);
                return errorMessage('Token not valid',500);

            }catch(Exception $e)
            {
                Log::info('Error in RoleController create:'.$e->getMessage());
                return errorMessage($e->getMessage(),500);
            }
    }

    public function assignRoleToUser($request)
    {
        try{

            $role= User::find($request->userId);
            $role->role_id = $request->roleId;
            $role->save();

            return $this->sendResponse(new UserResource($role), 'Successfully.Updated');

            }catch(InvalidTokenException $e){

                Log::info('Error in RoleController create:'.$e);
                return $this->sendError('Token not valid','',500);

            }catch(Exception $e)
            {
                Log::info('Error in RoleController create:'.$e->getMessage());
                return $this->sendError($e->getMessage(),'',500);
            }
    }

    public function delete($request)
    {
        try{

            if(!Role::destroy($request->roleId))
            {
                throw new Exception('Error on deleting Role');
            }


            $role =Role::destroy($request->roleId);

            return successMessage('Successfully.Updated',200);

        }catch(InvalidTokenException $e){

            Log::info('Error in RoleController create:'.$e);
            return errorMessage('Token not valid',500);

        }catch(Exception $e)
        {
            Log::info('Error in RoleController create:'.$e->getMessage());
            return errorMessage($e->getMessage(),500);
        }
    }

    public function list()
    {
        try{

            $role =Role::with('rolePermissions')->get();

            return successResponse(new RoleCollection($role),200);

        }catch(InvalidTokenException $e){

            Log::info('Error in RoleController create:'.$e);
            return errorMessage('Token not valid',500);

        }catch(Exception $e)
        {
            Log::info('Error in RoleController create:'.$e->getMessage());
            return errorMessage($e->getMessage(),500);
        }
    }
}
