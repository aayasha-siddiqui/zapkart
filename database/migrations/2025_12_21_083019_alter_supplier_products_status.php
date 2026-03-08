<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('supplier_products', function (Blueprint $table) {
            // purana enum drop karo
            $table->dropColumn('status');
        });

        Schema::table('supplier_products', function (Blueprint $table) {
            // naya enum add karo
            $table->enum('status', ['available','sold'])
                  ->default('available')
                  ->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('supplier_products', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('supplier_products', function (Blueprint $table) {
            $table->enum('status', ['pending','approved','rejected'])
                  ->default('pending')
                  ->after('image');
        });
    }
};
