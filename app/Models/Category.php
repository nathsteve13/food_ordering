<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    // Define the table associated with the model
    protected $table = 'categories';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'created_at',
        'updated_at',
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class, 'categories_id');
    }
}