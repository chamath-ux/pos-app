<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

       /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description'
    ];

    // protected $hidden = [
    //     'created_at',
    //     'updated_at',
    //     'pivot',
    //     'description'
    // ];


    public function roles()
    {
      return $this->belongsToMany(Role::class);
    }

    public function users()
    {
      return $this->belongsToMany(User::class);
    }
}
