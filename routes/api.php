<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

require __DIR__ . '/authRoutes.php';

Route::middleware(['auth:sanctum'])->group(function () {

    Route::prefix('product')->group(function(){
        Route::post('create-product',[ProductController::class,'create'])->middleware('permission:create-product');
    });
});


