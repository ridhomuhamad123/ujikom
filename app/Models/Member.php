<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

        protected $table = 'members';

        protected $fillable = ['name', 'no_phone', 'poin'];
    
        public function purchases()
        {
            return $this->hasMany(Purchase::class);
        }
}
