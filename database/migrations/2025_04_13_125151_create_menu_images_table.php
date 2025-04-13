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
        Schema::create('menu_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menus_id');
            $table->string('image_path', 255);
            $table->timestamps();
        
            $table->foreign('menus_id')->references('id')->on('menus')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_images');
    }
};
