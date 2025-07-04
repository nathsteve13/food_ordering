<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = ['name'];

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menus_has_ingredients');
    }
    public function excludedInTransactions()
    {
        return $this->hasMany(DetailTransactionExclude::class, 'ingredients_id');
    }

}
