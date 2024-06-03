<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{

    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $product= Product::latest()->first();

        $str = explode('/',$product->code);

        $product->code = $str[0].'/'.IntVal($str[1])+1;

    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
