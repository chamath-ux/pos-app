<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AssignRoleToUserAction
{
    /**
     * Handle the creation of a assign role to user.
     *
     * @param  object  $data
     * @return \App\Models\User
     * @throws \Illuminate\Validation\ValidationException
     */
    public function execute(object $data): User
    {

        $role= User::find($data->userId);
        $role->role_id = $data->roleId;
        $role->save();

        // Create the user
        return $role;
    }
}
