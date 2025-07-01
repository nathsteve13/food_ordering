<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransactionExclude extends Model
{
    use HasFactory;

    protected $table = 'detail_transaction_excludes';
    public $timestamps = true;

    protected $fillable = [
        'detail_transaction_id',
        'ingredients_id',
    ];

    public function detailTransaction()
    {
        return $this->belongsTo(DetailTransaction::class);
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredients_id');
    }
}
