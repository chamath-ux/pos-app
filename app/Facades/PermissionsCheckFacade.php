<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class PermissionsCheckFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\CheckPermissionService::class;
    }
}
