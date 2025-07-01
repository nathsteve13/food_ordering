<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartIngredients extends Model
{
    use HasFactory;
    protected $table = 'cart_ingredients';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'cart_id',
        'menu_has_ingredient_id',
    ];
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
    public function menuIngredient()
    {
        return $this->belongsTo(MenuHasIngredient::class, 'menu_has_ingredient_id');
    }
}
