<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    /**
     * get questions related to category
     */

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
