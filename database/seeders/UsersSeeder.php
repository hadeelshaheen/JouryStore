<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
            [   'id' => 1,
                'user_id' => NULL,
                'name' => "Laravel Password Grant Client",
                'secret' => "qlS8v6g5PnPSTasjNZxRxtogJM1qLSWH9Otq14DA",
                'provider' => NULL,
                'redirect' => "http://localhost",
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => '2021-04-21 17:34:06',
                'updated_at' => '2021-04-21 17:34:06'
            ],

        ]);
    }
}
