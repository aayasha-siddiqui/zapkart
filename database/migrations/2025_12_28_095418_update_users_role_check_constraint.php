<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // purana constraint hatao
        DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");

        // naya constraint add karo (shopkeeper ke sath)
        DB::statement("
            ALTER TABLE users
            ADD CONSTRAINT users_role_check
            CHECK (role IN (
                'admin',
                'user',
                'seller',
                'supplier',
                'driver',
                'shopkeeper'
    
            ))
        ");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");

        DB::statement("
            ALTER TABLE users
            ADD CONSTRAINT users_role_check
            CHECK (role IN ('admin','user','seller','supplier'))
        ");
    }
};
