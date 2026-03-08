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
    Schema::create('supplier_products', function (Blueprint $table) {
    $table->id();
    $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
    $table->foreignId('supplier_category_id')->constrained('supplier_categories')->cascadeOnDelete();

    $table->string('name');
    $table->decimal('price', 10, 2);
    $table->text('description')->nullable();
    $table->string('image')->nullable();

    $table->enum('status',['pending','approved','rejected'])->default('pending');

    $table->timestamps();
});




    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_products');
    }
};
