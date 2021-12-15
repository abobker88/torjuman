<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderOperationCancel extends Model
{
    use HasFactory;

    protected $guarded=[];
    public function order()
    {
        return $this->hasOne('App\Models\Order', 'id', 'order_id');
    }

    public function operation()
    {
        return $this->hasOne('App\Models\User', 'id', 'operation_id');
    }

    public function customerService()
    {
        return $this->hasOne('App\Models\User', 'id', 'customer_service_id');
    }
}
