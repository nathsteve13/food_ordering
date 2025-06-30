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
        'menus_has_ingredient_id',
    ];
}
