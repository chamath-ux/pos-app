<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleCollection;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(){ $this->roleService = new RoleService(); }

    public function create(Request $request){ return $this->roleService->create($request); }

    public function assignPermissionToUser(Request $request){ return $this->roleService->assignRoleToUser($request); }

    public function deleteRole(Request $request){ return $this->roleService->delete($request); }

    public function roleList(){ return $this->roleService->list();  }
}
