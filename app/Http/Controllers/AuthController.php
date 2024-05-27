<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\AuthRequest;
use App\Services\PermissionService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Http\Requests\RegisterUserRequest;

class AuthController extends BaseController
{
    public function login(AuthRequest $request , AuthService $authService)
    {

        if(!Auth::attempt($request->all()))
        {
            return $this->sendError('Credentials not matching');
        }

        $user = Auth::user();
        $success = $authService->getAuthUser();
        return $this->sendResponse($success, 'User login successfully.');
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
        'message' => 'Successfully logged out'
        ]);
    }

    public function register(RegisterUserRequest $request)
    {
        try{

            $user = User::create([
                'first_name'=>$request['first_name'],
                'last_name'=>$request['last_name'],
                'email'=>$request['email'],
                'password'=>$request['password'],
                'isAdmin'=> $request['isAdmin']
            ]);

            $user['token'] = $user->createToken('MyApp',['*'],now()->addWeek())->plainTextToken;

            return $this->sendResponse($user, 'User registered successfully.');

        }catch(Exception $e)
        {
            Log::info('Error in AuthController register:'.$e);
            return $this->sendError('User data not inserted','',500);
        }
    }


}
