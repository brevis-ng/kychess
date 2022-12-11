<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            ConfigSeeder::class,
        ]);

        \App\Models\Activity::factory()
            ->count(10)
            ->state(
                new Sequence(
                    ["repeatable" => true],
                    [
                        "repeatable" => false,
                        "repetition_name" => Str::random(20),
                    ]
                )
            )
            ->has(\App\Models\Ticket::factory()->count(200), "tickets")
            ->create();
    }
}
