<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {

    public function up()
    {
        // old constraint hatao
        DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");

        // new constraint with ALL roles
        DB::statement("
            ALTER TABLE users
            ADD CONSTRAINT users_role_check
            CHECK (role IN (
                'admin',
                'user',
                'supplier',
                'seller',
                'warehouse',
                'driver'
            ))
        ");
    }

    public function down()
    {
        // rollback ke time minimal roles
        DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");

        DB::statement("
            ALTER TABLE users
            ADD CONSTRAINT users_role_check
            CHECK (role IN ('admin','user','driver'))
        ");
    }
};
