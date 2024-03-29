<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderChecker extends Model
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

    public function checker()
    {
        return $this->hasOne('App\Models\User', 'id', 'checker_id');
    }
}
