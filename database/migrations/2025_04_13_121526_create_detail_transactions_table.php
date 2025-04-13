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
        Schema::create('detail_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transactions_invoice_number');
            $table->unsignedBigInteger('menus_id');
            $table->double('portion');
            $table->integer('quantity');
            $table->double('total');
            $table->string('notes');
            $table->timestamps();
        
            $table->foreign('transactions_invoice_number')->references('invoice_number')->on('transactions');
            $table->foreign('menus_id')->references('id')->on('menus');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transactions');
    }
};
