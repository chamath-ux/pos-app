<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $userService;

    public function __construct(){ $this->userService = new UserService(); }

    public function create(UserRequest $request, User $user){ return $this->userService->create($request, $user); }

    public function users(User $user){ return $this->userService->userList($user); }

    public function deleteUser(Request $request ,User $user){ return $this->userService->delete($request, $user); }

    public function show($user_id){ return $this->userService->show($user_id); }
}
