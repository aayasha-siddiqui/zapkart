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
    Schema::table('users', function (Blueprint $table) {

        // DROP phone column
        if (Schema::hasColumn('users', 'phone')) {
            $table->dropColumn('phone');
        }

        // DROP phone_verified_at column
        if (Schema::hasColumn('users', 'phone_verified_at')) {
            $table->dropColumn('phone_verified_at');
        }

        // DROP password column
        if (Schema::hasColumn('users', 'password')) {
            $table->dropColumn('password');
        }
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {

        // Add back phone
        if (!Schema::hasColumn('users', 'phone')) {
            $table->string('phone')->nullable();
        }

        // Add back phone_verified_at
        if (!Schema::hasColumn('users', 'phone_verified_at')) {
            $table->timestamp('phone_verified_at')->nullable();
        }

        // Add back password
        if (!Schema::hasColumn('users', 'password')) {
            $table->string('password')->nullable();
        }
    });
}

};
