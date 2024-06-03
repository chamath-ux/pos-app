<?php

namespace App\Services;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\AuthResource;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * Get Authenticated user data
     * @return array
     */
    public function authUser($request)
    {
        try{

            if(!Auth::attempt($request->validated()))
            {
                throw new Exception('Credentials not matching');
            }

            $user['token']=auth()->user()->createToken('MyApp',[''],now()->addWeek())->plainTextToken;

            return successResponse($user);


        }catch(Exception $e)
        {
            Log::info('Error in AuthController register:'.$e);
            return errorMessage($e->getMessage(),500);
        }
    }

    /**
     * new user register
     * @return void
     */

     public function registerUser($request)
     {
        try{

            $user = User::create($request->validated());

            if(!$user)
            {
                throw new Exception('Error on user registration');
            }

            return successMessage('Successfully Register');

        }catch(Exception $e)
        {
            Log::info('Error in AuthController register:'.$e);
            return errorMessage($e->getMessage(),500);
        }
     }

     /**
      * Auth User Details
      *@return array
      */
    public function userDetails()
    {
        try{

            $user = User::with(['permissions','role'])->find(auth()->user()->id);
            return successResponse(new AuthResource($user));

        }catch(Exception $e)
        {
            Log::info('Error in AuthController userDetails:'.$e);
            return errorMessage($e->getMessage(),500);
        }
    }

    public function resetPassword($request)
    {
        try{

            $user = User::find(auth()->user()->id);
            $user->password=$request->password;
            $user->save();

            return successMessage('Password Successfully reset');

        }catch(Exception $e)
        {
            Log::info('Error in AuthController resetPassword:'.$e);
            return errorMessage($e->getMessage(),500);
        }
    }
}
