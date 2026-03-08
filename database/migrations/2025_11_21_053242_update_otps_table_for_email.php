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
    Schema::table('otps', function (Blueprint $table) {

        // Add email column only if not exists
        if (!Schema::hasColumn('otps', 'email')) {
            $table->string('email')->nullable()->after('id');
        }

        // Drop phone column if exists
        if (Schema::hasColumn('otps', 'phone')) {
            $table->dropColumn('phone');
        }
    });
}

public function down()
{
    Schema::table('otps', function (Blueprint $table) {

        // Rollback = remove email
        if (Schema::hasColumn('otps', 'email')) {
            $table->dropColumn('email');
        }

        // Add phone back
        if (!Schema::hasColumn('otps', 'phone')) {
            $table->string('phone')->nullable();
        }
    });
}

};
