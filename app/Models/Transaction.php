<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'invoice_number';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'invoice_number',
        'subtotal',
        'discount',
        'total',
        'order_type',
        'payment_type',
        'users_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function details()
    {
        return $this->hasMany(DetailTransaction::class, 'transactions_invoice_number');
    }

    public static function generateInvoiceNumber()
    {
        $today = now()->format('Y-m-d');
        $count = self::whereDate('created_at', now())->count() + 1;
        return 'INV-' . now()->format('Y-m-d') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function orderStatus()
    {
        return $this->hasOne(OrderStatus::class, 'transactions_invoice_number', 'invoice_number')
            ->latestOfMany();
    }
    public function statusHistory()
    {
        return $this->hasMany(OrderStatus::class, 'transactions_invoice_number', 'invoice_number')->orderBy('created_at');
    }
}
