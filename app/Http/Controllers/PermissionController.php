<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Services\PermissionService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(){ $this->permissionService = new PermissionService(); }

    public function givePermission(Request $request){ return $this->permissionService->givePermissionTo($request->userId,$request->permission); }

    public function removePermission(Request $request){ return $this->permissionService->removePermissionFrom($request->userId,$request->permission); }

    public function givePermissionToRole(Request $request){ return $this->permissionService->permissionToRole($request->roleId,$request->permission); }

    public function removePermissionFromRole(Request $request){ return $this->permissionService->removePermissionFromRole($request->roleId,$request->permission); }

    public function getAllPermissions(Permission $permission){   return $this->permissionService->getPermissionList($permission); }

    public function show($permission_id){ return $this->permissionService->show($permission_id); }
}
