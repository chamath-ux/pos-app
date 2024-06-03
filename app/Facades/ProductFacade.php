<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ProductFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\productService::class;
    }
}
