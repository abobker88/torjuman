<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCancelByUser extends Model
{
    use HasFactory;

    protected $guarded=[];
    public function order()
    {
        return $this->hasOne('App\Models\Order', 'id', 'order_id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
