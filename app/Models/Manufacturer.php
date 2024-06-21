<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    protected $fillable = ['name']; 
    use HasFactory;
}
