<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    
    protected $fillable = ['name','description','price','status','stock','discount','category_id','manufacturer_id','product_Code']; 
    
    
    
    public function cartItems()
    {
        return $this->hasMany(Cart_item::class);
    }


    
    use HasFactory;
}
