<?php

namespace App\Services;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserCollection;

class UserService
{
    public function create($request, $user)
    {
        try{

            $users = $user->create($request->validated());
            return successMessage('Created User Successfully.',200);

        }catch(InvalidTokenException $e){

            Log::info('Error in UserController create:'.$e);
            return errorMessage('Token not valid',500);

        }catch(Exception $e)
        {
            Log::info('Error in UserController create:'.$e->getMessage());
            return errorMessage($e->getMessage(),500);
        }
    }

    public function userList($user)
    {
        try{

            $users = $user->get(); // Fetch users from the database
            return successResponse(new UserCollection($users), 200);

        }catch(Exception $e)
        {
            Log::info('Error in UserController users:'.$e->getMessage());
            return errorMessage($e->getMessage(),500);
        }
    }

    public function delete($request, $user)
    {
        try{

            if(!$user->find($request->userId))
            {
                throw new Exception('This User dose not exists');
            }

            if($user->admin())
            {
                throw new Exception('This Deleting User is a admin you cannot delete admin users');
            }

            $user->destroy($request->userId);
            return successMessage('Successfully Deleted the user.',200);

        }catch(Exception $e)
        {
            Log::info('Error in UserController deleteUser:'.$e->getMessage());
            return errorMessage($e->getMessage(),500);
        }
    }

    public function show($user_id)
    {
        try{

            if(!User::find($user_id))
            {
                throw new Exception('This User dose not exists');
            }

            $user=User::with(['permissions','role'])->find($user_id);
            return successResponse(new UserResource($user),200);

        }catch(Exception $e)
        {
            Log::info('Error in UserController deleteUser:'.$e->getMessage());
            return errorMessage($e->getMessage(),500);
        }
    }
}
