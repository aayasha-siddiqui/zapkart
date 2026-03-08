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
    Schema::table('categories', function (Blueprint $table) {
        $table->foreignId('supplier_id')
              ->nullable()
              ->after('id')
              ->constrained('suppliers')
              ->onDelete('cascade');
    });
}


public function down()
{
    Schema::table('categories', function (Blueprint $table) {
        $table->dropForeign(['supplier_id']);
        $table->dropColumn('supplier_id');
    });
}

};
