<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use UserService;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function create(UserRequest $request, User $user){ return UserService::create($request, $user); }

    public function users(User $user){ return UserService::userList($user); }

    public function deleteUser(Request $request ,User $user){ return UserService::delete($request, $user); }

    public function show($user_id){ return UserService::show($user_id); }
}
