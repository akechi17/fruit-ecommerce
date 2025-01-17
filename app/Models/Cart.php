<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_barang', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id');
    }
}
