<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'kategori',
        'image_url',
        'stock',
        'harga_modal',
        'persen_keuntungan',
        'harga_jual',
        'is_available'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
}
