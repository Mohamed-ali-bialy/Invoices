<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart_item extends Model
{
    use HasFactory;
    protected $fillable = ['cart_id','product_id','quantity','price','discount','subtotal','tax','total','product_name']; 

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
