<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Permission;
use Illuminate\Http\Request;
use PermissionService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;

class PermissionController extends Controller
{

    public function givePermission(Request $request){ return PermissionService::givePermissionTo($request->userId,$request->permission); }

    public function removePermission(Request $request){ return PermissionService::removePermissionFrom($request->userId,$request->permission); }

    public function givePermissionToRole(Request $request){ return PermissionService::permissionToRole($request->roleId,$request->permission); }

    public function removePermissionFromRole(Request $request){ return PermissionService::removePermissionFromRole($request->roleId,$request->permission); }

    public function getAllPermissions(Permission $permission){   return PermissionService::getPermissionList($permission); }

    public function show($permission_id){ return PermissionService::show($permission_id); }
}
