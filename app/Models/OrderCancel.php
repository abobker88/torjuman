<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCancel extends Model
{
    use HasFactory;

    protected $guarded=[];
    public function order()
    {
        return $this->hasOne('App\Models\Order', 'id', 'order_id');
    }

    public function translator()
    {
        return $this->hasOne('App\Models\User', 'id', 'translator_id');
    }

    public function customerService()
    {
        return $this->hasOne('App\Models\User', 'id', 'customer_service_id');
    }
}
