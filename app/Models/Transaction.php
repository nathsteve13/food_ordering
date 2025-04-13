<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $primaryKey = 'invoice_number';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'invoice_number', 'subtotal', 'discount', 'total', 'order_type', 'payment_type', 'users_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function details()
    {
        return $this->hasMany(DetailTransaction::class, 'transactions_invoice_number');
    }

    public function orderStatus()
    {
        return $this->hasOne(OrderStatus::class, 'transactions_invoice_number');
    }
}
