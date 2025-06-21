<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $table = 'menus';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'name', 'description', 'nutrition_fact', 'price', 'stock', 'categories_id'
    ];

    public function details()
    {
        return $this->hasMany(DetailTransaction::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'menus_has_ingredients', 'menus_id', 'ingredients_id');
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
