<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'sale_date',
        'total_price',
        'total_pay',
        'total_return',
        'member_id',
        'user_id',
        'point',
        'point_use',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function details()
    {
        return $this->hasMany(DetailPurchase::class, 'purchases_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
