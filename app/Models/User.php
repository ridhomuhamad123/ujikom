<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = ['username', 'password', 'email', 'role'];
    
    protected $hidden = ['password'];
    public function purchases()
{
    return $this->hasMany(Purchase::class, 'user_id');
}

}