<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('invoice_number')->primary();
            $table->double('subtotal');
            $table->double('discount');
            $table->double('total');
            $table->enum('order_type', ['dinein', 'takeaway']);
            $table->enum('payment_type', ['qris', 'credit', 'debit', 'e-wallet']);
            $table->unsignedBigInteger('users_id');
            $table->timestamps();
        
            $table->foreign('users_id')->references('id')->on('users');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
