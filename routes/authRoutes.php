<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;


Route::group(['prefix'=>'auth'],function(){
    Route::post('login',[AuthController::class,'login']);
    Route::post('register',[AuthController::class,'register']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class,'logout']);
    Route::get('user-details',[AuthController::class,'userDetails']);
    Route::post('password-set',[AuthController::class,'resetPassword']);

    Route::prefix('permissions')->group(function(){

        Route::middleware(['permission:assign_permission'])->group(function(){
            Route::post('permission',[PermissionController::class,'givePermission']);
            Route::post('role-permission',[PermissionController::class,'givePermissionToRole']);
        });

        Route::middleware(['permission:remove_permission'])->group(function(){
            Route::post('remove-permission',[PermissionController::class,'removePermission']);
            Route::post('remove-role-permission',[PermissionController::class,'removePermissionFromRole']);
        });

        Route::get('all-permission-list',[PermissionController::class,'getAllPermissions'])->middleware('permission:show_list');
        Route::get('show/{permission_id}',[PermissionController::class,'show'])->middleware('permission:show_permission');

    });

    Route::prefix('user')->group(function(){

            Route::get('/user', [UserController::class,'users'])->middleware('permission:view_users');
            Route::post('/delete-user', [UserController::class,'deleteUser'])->middleware('permission:delete_user');
            Route::post('/create',[UserController::class,'create'])->middleware('permission:create_user');
            Route::get('show/{user_id}',[UserController::class,'show'])->middleware('permission:show_user');

    });

    Route::prefix('role')->group(function(){

            Route::post('create-role',[RoleController::class,'create'])->middleware('permission:create_role');
            Route::post('assign-role-to-user',[RoleController::class,'assignPermissionToUser'])->middleware('permission:assign_role');
            Route::post('delete-role',[RoleController::class,'deleteRole'])->middleware('permission:delete_role');
            Route::get('role-list',[RoleController::class,'roleList'])->middleware('permission:show_role_list');
            Route::get('show/{role_id}',[RoleController::class,'show'])->middleware('permission:show_role_details');
            Route::post('remove-role/{user_id}',[RoleController::class,'removeRole'])->middleware('permission:remove_user_role');

    });
});
