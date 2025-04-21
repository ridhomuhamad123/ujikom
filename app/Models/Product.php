<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    use HasFactory;
    protected $fillable = ['name', 'price', 'stock', 'image'];

    public function details()
    {
        return $this->hasMany(DetailPurchase::class, 'products_id');
    }
}
