<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryPartnersTable extends Migration
{
    public function up()
    {
        Schema::create('delivery_partners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Identity
            $table->string('full_name');
            $table->string('father_name')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['male','female','other'])->nullable();
            $table->string('profile_photo')->nullable();

            // Address
            $table->string('city');
            $table->string('state');
            $table->text('address')->nullable();

            // Vehicle & License
            $table->enum('vehicle_type', ['bike','scooty','cycle']);
            $table->string('driving_license_number');
            $table->string('driving_license_front')->nullable();
            $table->string('driving_license_back')->nullable();

            // Optional security doc
            $table->string('police_verification')->nullable();

            // System fields
            $table->string('partner_code')->unique()->nullable();
            $table->enum('status', ['pending','approved','rejected'])->default('pending');
            $table->enum('online_status', ['online','offline'])->default('offline');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('delivery_partners');
    }
}
