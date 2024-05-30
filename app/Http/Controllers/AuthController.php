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
    protected $authService;

    public function __construct(){ $this->authService = new AuthService(); }

    public function login(AuthRequest $request){ return $this->authService->authUser($request); }

    public function userDetails(){ return $this->authService->userDetails(); }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
        'message' => 'Successfully logged out'
        ]);
    }

    public function register(RegisterUserRequest $request){ return $this->authService->registerUser($request); }


}
