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
        Schema::create('menus_has_ingredients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menus_id');
            $table->unsignedBigInteger('ingredients_id');
            $table->timestamps();
        
            $table->foreign('menus_id')->references('id')->on('menus');
            $table->foreign('ingredients_id')->references('id')->on('ingredients');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus_has_ingredients');
    }
};
