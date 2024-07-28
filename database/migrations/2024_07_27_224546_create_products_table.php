<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class,'user_id')->constrained('users');
            $table->foreignIdFor(Category::class,'category_id')->constrained('categories');
            $table->unsignedInteger('barcode');
            $table->text('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('stock')->nullable();
            $table->unsignedInteger('purchase_price')->nullable();
            $table->unsignedInteger('sell_price');
            $table->text('image')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
