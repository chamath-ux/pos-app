<?php

namespace App\Services;

use Exception;
use App\Models\product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductService
{
    public function create($request)
    {
        try{
            DB::beginTransaction();

            $product = Product::create($request->validated());

            DB::commit();
            dd($product);
            return successMessage('Product Created Successfully.',200);

        }catch(InvalidTokenException $e){

            DB::rollBack();

            Log::info('Error in ProductService create:'.$e);
            return errorMessage('Token not valid',500);

        }catch(Exception $e)
        {
            DB::rollBack();

            Log::info('Error in ProductService create:'.$e->getMessage());
            return errorMessage($e->getMessage(),500);
        }
    }
}
