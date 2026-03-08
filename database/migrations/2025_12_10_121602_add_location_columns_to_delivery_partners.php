<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('delivery_partners', function (Blueprint $table) {

            // Add latitude column if missing
            if (!Schema::hasColumn('delivery_partners', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable();
            }

            // Add longitude column if missing
            if (!Schema::hasColumn('delivery_partners', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable();
            }

            // Add last update timestamp if missing
            if (!Schema::hasColumn('delivery_partners', 'location_updated_at')) {
                $table->timestamp('location_updated_at')->nullable();
            }

        });
    }

    public function down()
    {
        Schema::table('delivery_partners', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'location_updated_at']);
        });
    }
};
