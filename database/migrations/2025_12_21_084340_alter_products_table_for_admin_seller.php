<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ❌ supplier_id safely remove
        if (Schema::hasColumn('products', 'supplier_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('supplier_id');
            });
        }

        // ❌ status remove
        if (Schema::hasColumn('products', 'status')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }

        // ✅ source add if not exists
        if (!Schema::hasColumn('products', 'source')) {
            Schema::table('products', function (Blueprint $table) {
                $table->enum('source', ['admin','seller'])
                      ->after('category_id');
            });
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('supplier_id')->nullable();
            $table->string('status')->nullable();
        });
    }
};
