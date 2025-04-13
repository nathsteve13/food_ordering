<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'address', 'phone_numeber', 'username', 'password'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'users_id');
    }
}
