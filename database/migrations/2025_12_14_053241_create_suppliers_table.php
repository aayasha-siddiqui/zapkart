<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();

            $table->string('supplier_code')->unique();   // SUP-0001
            $table->foreignId('user_id')->constrained('users');

            $table->string('name');
            $table->string('business_name');
            $table->string('phone');
            $table->string('email');
            $table->text('address')->nullable();
            $table->string('gst')->nullable();

            $table->enum('status', ['active','inactive'])->default('active');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
};
