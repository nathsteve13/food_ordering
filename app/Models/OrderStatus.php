<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $fillable = [
        'transactions_invoice_number', 'status_type'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transactions_invoice_number');
    }
}
