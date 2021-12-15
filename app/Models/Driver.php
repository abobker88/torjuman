<?php

namespace App\Models;

use App\Interfaces\IdentifiedByInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Driver extends Authenticatable 
{
    use Notifiable, SoftDeletes , HasFactory;

    public $table = 'drivers';

    protected $dates = ['deleted_at'];

    protected $hidden = ['password', 'api_token', 'deleted_at'];

    protected $guarded=[];

    const IMAGEPATH = 'drivers';

    public function documents()
    {
        return $this->morphMany(Document::class, 'model');
    }
    public function geo()
    {
        return $this->hasMany(DriverGeo::class);
    }
    public function vehicle()
    {
        return $this->hasOne(Vehicle::class);
    }
}
