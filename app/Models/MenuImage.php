<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuImage extends Model
{
    use HasFactory;
    protected $table = 'menus_images';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = [
        'menus_id',
        'image_path',
    ];
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menus_id');
    }
}
