<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
    protected $fillable = [
        'transactions_invoice_number', 'menus_id', 'portion', 'quantity', 'total', 'notes'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transactions_invoice_number');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menus_id');
    }

    public function excludedIngredients()
    {
        return $this->hasMany(DetailTransactionExclude::class, 'detail_transaction_id')
                    ->with('ingredient');
    }



}
