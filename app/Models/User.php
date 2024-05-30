<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use App\Models\Permission;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'isAdmin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /**
     * Set the user's password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

     /**
      * Set the user's isAdmin.
      *
      * @param string $value
      * @return void
      */

      public function setIsAdminAttribute($value)
      {
        $this->attributes['isAdmin'] = ($value == 'yes')? 1 : 0;
      }

      /**
       * check auth user admin or not
       * @return boolean
       */

      public function admin()
      {
        return ($this->isAdmin === 1 && $this->role_id === 1);
      }

      public function permissions()
      {
        return $this->belongsToMany(Permission::class);
      }

      public function role()
      {
        return $this->belongsTo(Role::class)->with('rolePermissions');
      }

}
