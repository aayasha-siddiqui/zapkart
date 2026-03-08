<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('order_number')->unique();
        $table->decimal('subtotal', 10, 2);
        $table->decimal('delivery_charges', 10, 2);
        $table->decimal('total', 10, 2);
        $table->string('payment_method')->default('cod');
        $table->string('payment_status')->default('pending');
        $table->string('status')->default('placed');
        $table->timestamps();
    });
}   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
