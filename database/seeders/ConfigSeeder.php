<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configs')->insert([
            'operator' => 'Administrator',
            'meta_key' => 'ip_whitelist',
            'meta_value' => env('ROOT_IP', '127.0.0.1'),
            'meta_desc' => '白名单IP地址',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
