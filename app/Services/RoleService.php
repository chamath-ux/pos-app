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

            $role= Role::create($request->validated());
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

            if(!User::find($request->userId))
            {
                throw new Exception('This user not exists');
            }


            $role= User::find($request->userId);
            $role->role_id = $request->roleId;
            $role->save();


            return successMessage('Successfully Updated');

            }catch(InvalidTokenException $e){

                Log::info('Error in RoleController assignRoleToUser:'.$e);
                return errorMessage('Token not valid',500);

            }catch(Exception $e)
            {
                Log::info('Error in RoleController assignRoleToUser:'.$e->getMessage());
                return errorMessage($e->getMessage(),500);
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

            $role =Role::all();

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

    public function show($role_id)
    {
        try{

            $role =Role::with(['rolePermissions','users'])->find($role_id);

            return successResponse(new RoleResource($role),200);

        }catch(InvalidTokenException $e){

            Log::info('Error in RoleController create:'.$e);
            return errorMessage('Token not valid',500);

        }catch(Exception $e)
        {
            Log::info('Error in RoleController create:'.$e->getMessage());
            return errorMessage($e->getMessage(),500);
        }
    }

    public function removeRoleFromUser($user_id)
    {
        try{


            $user =User::find($user_id);
            $user->role_id = Null;
            $user->save();

            return successMessage('SuccessFully removed the user role',200);

        }catch(InvalidTokenException $e){

            Log::info('Error in RoleController removeRoleFromUser:'.$e);
            return errorMessage('Token not valid',500);

        }catch(Exception $e)
        {
            Log::info('Error in RoleController removeRoleFromUser:'.$e->getMessage());
            return errorMessage($e->getMessage(),500);
        }
    }
}
