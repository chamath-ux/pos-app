<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

      /* Get the user that owns the Question
      *
      * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
      */
     public function category(): BelongsTo
     {
         return $this->belongsTo(Category::class);
     }

}
