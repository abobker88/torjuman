<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasFactory, Notifiable,HasRoles,HasApiTokens,SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'api_token',
        'fcm_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function order()
    {
        return $this->hasMany('App\Models\Order', 'user_id', 'id');
    }

    // public function scopeNotRole(Builder $query, $roles, $guard = null): Builder 
    // { 
    //      if ($roles instanceof Collection) { 
    //          $roles = $roles->all(); 
    //      } 
  
    //      if (! is_array($roles)) { 
    //          $roles = [$roles]; 
    //      } 
  
    //      $roles = array_map(function ($role) use ($guard) { 
    //          if ($role instanceof Role) { 
    //              return $role; 
    //          } 
  
    //          $method = is_numeric($role) ? 'findById' : 'findByName'; 
    //          $guard = $guard ?: $this->getDefaultGuardName(); 
  
    //          return $this->getRoleClass()->{$method}($role, $guard); 
    //      }, $roles); 
  
    //      return $query->whereHas('roles', function ($query) use ($roles) { 
    //          $query->where(function ($query) use ($roles) { 
    //              foreach ($roles as $role) { 
    //                  $query->where(config('permission.table_names.roles').'.id', '!=' , $role->id); 
    //              } 
    //          }); 
    //      }); 
    // }
}
