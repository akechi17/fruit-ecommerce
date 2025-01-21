<?php

namespace App\Models;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'product',
        'supplier_id',
        'kuantitas',
        'total_harga',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
