<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name', 'description', 'nutrition_fact', 'price', 'stock'
    ];

    public function details()
    {
        return $this->hasMany(DetailTransaction::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'menus_has_ingredients');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }
    public function images()
    {
        return $this->hasMany(MenuImage::class, 'menus_id');
    }
}
