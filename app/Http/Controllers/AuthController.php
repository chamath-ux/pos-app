<?php

namespace App\Http\Controllers;

use AuthService;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Services\PermissionService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PasswordRequest;
use App\Http\Controllers\BaseController;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\ResetPasswordRequest;

class AuthController extends BaseController
{

    public function login(AuthRequest $request){ return AuthService::authUser($request); }

    public function userDetails(){ return AuthService::userDetails(); }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
        'message' => 'Successfully logged out'
        ]);
    }

    public function register(RegisterUserRequest $request){ return AuthService::registerUser($request); }

    public function resetPassword(PasswordRequest $request){ return AuthService::resetPassword($request); }
}
