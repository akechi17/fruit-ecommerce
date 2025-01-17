<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Discount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
     public function discount()
    {
        return $this->hasMany(Discount::class);
    }
}
