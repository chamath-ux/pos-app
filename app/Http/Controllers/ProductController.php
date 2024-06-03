<?php

namespace App\Http\Controllers;

use ProductService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function create(ProductRequest $request){ return ProductService::create($request); }
}
