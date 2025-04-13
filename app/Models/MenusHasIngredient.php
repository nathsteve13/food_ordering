<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenusHasIngredient extends Model
{
    protected $table = 'menus_has_ingredients';

    protected $fillable = ['menus_id', 'ingredients_id'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
}
