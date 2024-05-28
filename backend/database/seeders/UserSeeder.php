<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Guest',
            'email' => 'guest@gmail.com',
            'password' => bcrypt('000000'),
            'created_by' => 'system-UserSeeder',
            'updated_by' => 'system-UserkSeeder'
        ]);
    }
}
