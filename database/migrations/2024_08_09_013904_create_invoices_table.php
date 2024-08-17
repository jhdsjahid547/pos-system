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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->decimal('subtotal');
            $table->decimal('discount_percent')->nullable();
            $table->decimal('discount')->nullable();
            $table->decimal('vat_percent');
            $table->decimal('vat');
            $table->decimal('total');
            $table->decimal('due');
            $table->decimal('paid');
            $table->tinyText('payment_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
