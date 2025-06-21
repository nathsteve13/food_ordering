<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detail_transaction_excludes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detail_transaction_id');
            $table->unsignedBigInteger('ingredients_id');
            $table->timestamps();

            $table->foreign('detail_transaction_id')
                  ->references('id')->on('detail_transactions')
                  ->onDelete('cascade');

            $table->foreign('ingredients_id')
                  ->references('id')->on('ingredients')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaction_excludes');
    }
};
