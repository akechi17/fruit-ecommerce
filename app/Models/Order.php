<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function customer(){
        return $this->belongsTo(Customer::class, 'id_customer', 'id');
    }

    public function payment(){
        return $this->hasMany(Payment::class);
    }
}
