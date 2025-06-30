<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'users_id',
        'menus_id',
        'quantity',
        'menus_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menus_id');
    }
    public function ingredients()
    {
        return $this->belongsToMany(MenusHasIngredient::class, 'cart_ingredients', 'cart_id', 'menus_has_ingredient_id');
    }
}
