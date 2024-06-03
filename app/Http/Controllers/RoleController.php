<?php

namespace App\Http\Controllers;

use RoleService;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleCollection;
use App\Http\Requests\Role\AssignRoleRequest;
use App\Http\Requests\Role\CreateRoleRequest;

class RoleController extends Controller
{

    public function create(CreateRoleRequest $request){ return RoleService::create($request); }

    public function assignPermissionToUser(AssignRoleRequest $request){ return RoleService::assignRoleToUser($request->validated()); }

    public function deleteRole(Request $request){ return RoleService::delete($request); }

    public function roleList(){ return RoleService::list();  }

    public function show($role_id){ return RoleService::show($role_id); }

    public function removeRole($user_id){ return RoleService::removeRoleFromUser($user_id); }
}
