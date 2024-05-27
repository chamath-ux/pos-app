<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Services\PermissionService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;

class UserController extends BaseController
{
    public function create(UserRequest $request, User $user)
    {
        try{

            $users = $user->create($request->all());
            return $this->sendResponse($users, 'Created User Successfully.');

        }catch(InvalidTokenException $e){

            Log::info('Error in UserController create:'.$e);
            return $this->sendError('Token not valid','',500);

        }catch(Exception $e)
        {
            Log::info('Error in UserController create:'.$e->getMessage());
            return $this->sendError($e->getMessage(),'',500);
        }


    }

    public function users(User $user)
    {
        try{

            $users = $user->all(); // Fetch users from the database
            return $this->sendResponse($users, 'Successfully got the users.');

        }catch(Exception $e)
        {
            Log::info('Error in UserController users:'.$e->getMessage());
            return $this->sendError($e->getMessage(),'',500);
        }
    }

    public function deleteUser(Request $request ,User $user)
    {
        try{

            if(!$user->find($request->userId))
            {
                return $this->sendError('This User dose not exists','',500);
            }

            if($user->admin())
            {
                throw new Exception('This Deleting User is a admin you cannot delete admin users');
            }

            $user->destroy($request->userId);
            return $this->sendResponse($user, 'Successfully Deleted the user.');

        }catch(Exception $e)
        {
            Log::info('Error in UserController deleteUser:'.$e->getMessage());
            return $this->sendError($e->getMessage(),'',500);
        }
    }
}
