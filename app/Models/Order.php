<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_code',
        'nama_pemesan',
        'order_date',
        'payment_method',
        'total_uang_masuk',
        'total_modal',
        'total_profit',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
