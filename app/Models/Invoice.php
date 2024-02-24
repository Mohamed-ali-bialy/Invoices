<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'seller_name',
        'seller_invoice_number',
        'shipment_number',
        'invoice_amount',
        'status',
    ];

    // Your existing Invoice model code...

    /**
     * Define the inverse of the one-to-many relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
