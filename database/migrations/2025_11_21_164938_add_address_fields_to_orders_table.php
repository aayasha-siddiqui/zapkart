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
    Schema::table('orders', function (Blueprint $table) {
        $table->string('name')->nullable();
        $table->string('phone')->nullable();
        $table->string('address_line')->nullable();
        $table->string('city')->nullable();
        $table->string('pincode')->nullable();
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['name', 'phone', 'address_line', 'city', 'pincode']);
    });
}

};
