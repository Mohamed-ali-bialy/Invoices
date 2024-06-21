<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','grand_total','subtotal','overall_discount','net_total']; 
 
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function cartItems() {
        return $this->hasMany(Cart_item::class);
    }

    public function getAllCartItems()
{
    // Retrieve the cart for the authenticated user
    $cart = Cart::where('user_id', auth()->id())->first();

    // If the cart doesn't exist, return an empty array or handle it as needed
    if (!$cart) {
        return [];
    }

    // Retrieve all cart items associated with the cart
    $cartItems = $cart->cart_items;

    return $cartItems;
}
}
