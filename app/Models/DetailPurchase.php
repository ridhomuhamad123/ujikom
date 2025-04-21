<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPurchase extends Model
{
    protected $table = 'detail_sales';
    protected $fillable =  [
        'products_id',
        'purchases_id',
        'quantity',
        'sub_total'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }
    use HasFactory;
}
