<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\User::create([
            'username' => 'admin',
            'name' => 'Administrator',
            'password' => Hash::make('password'),
            'status' => true
        ]);

        \App\Models\Config::create([
            'operator' => 'Administrator',
            'meta_key' => 'ip_whitelist',
            'meta_value' => '127.0.0.1,180.232.113.168',
            'meta_desc' => '白名单IP地址',
        ]);
    }
}
