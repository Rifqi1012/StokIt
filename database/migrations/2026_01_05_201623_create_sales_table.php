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
        Schema::create('sales', function (\Illuminate\Database\Schema\Blueprint $table) {
        $table->id();

        $table->foreignId('inventory_id')->constrained('inventories')->cascadeOnDelete();
        $table->foreignId('channel_id')->nullable()->constrained('channels')->nullOnDelete();

        $table->string('customer')->nullable();
        $table->date('date');

        $table->unsignedInteger('qty')->default(1);
        $table->unsignedBigInteger('total_price')->default(0);

        $table->string('status')->default('unpaid'); 

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
