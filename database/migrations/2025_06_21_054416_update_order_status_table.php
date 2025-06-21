<?php

use Illuminate\Bus\PendingBatch;
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
        Schema::table('order_status', function (Blueprint $table) {
            $table->enum('status_type', ['pending', 'proccessed', 'ready'])
                ->default('pending')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_status', function (Blueprint $table) {
            $table->enum('status_type', ['pending', 'proccessed', 'ready'])
                ->default(null)
                ->change();
        });
    }
};
