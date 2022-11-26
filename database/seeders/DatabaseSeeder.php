<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Rule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Rules seed
        DB::table('rules')->insert([
            ['name' => 'admin_config', 'pid' => 0, 'rank' => 0, 'created_at' => now()],
            
            ['name' => 'admin_index',   'action' => 'viewAny',      'pid' => 1, 'rank' => 1, 'created_at' => now()],
            ['name' => 'admin_add',     'action' => 'create',      'pid' => 2, 'rank' => 2, 'created_at' => now()],
            ['name' => 'admin_add',     'action' => 'create',     'pid' => 2, 'rank' => 2, 'created_at' => now()],
            ['name' => 'admin_del',     'action' => 'delete',    'pid' => 2, 'rank' => 2, 'created_at' => now()],
            ['name' => 'admin_edit',    'action' => 'update',     'pid' => 2, 'rank' => 2, 'created_at' => now()],
            ['name' => 'admin_edit',    'action' => 'update',       'pid' => 2, 'rank' => 2, 'created_at' => now()],
            ['name' => 'admin_show',    'action' => 'view',       'pid' => 2, 'rank' => 2, 'created_at' => now()],

            ['name' => 'group_index',   'action' => 'group.index',      'pid' => 1, 'rank' => 1, 'created_at' => now()],
            ['name' => 'group_add',     'action' => 'group.store',      'pid' => 9, 'rank' => 2, 'created_at' => now()],
            ['name' => 'group_add',     'action' => 'group.create',     'pid' => 9, 'rank' => 2, 'created_at' => now()],
            ['name' => 'group_del',     'action' => 'group.destroy',    'pid' => 9, 'rank' => 2, 'created_at' => now()],
            ['name' => 'group_edit',    'action' => 'group.update',     'pid' => 9, 'rank' => 2, 'created_at' => now()],
            ['name' => 'group_edit',    'action' => 'group.edit',       'pid' => 9, 'rank' => 2, 'created_at' => now()],
            ['name' => 'group_show',    'action' => 'group.show',       'pid' => 9, 'rank' => 2, 'created_at' => now()],

            ['name' => 'rules_index',   'action' => 'rules.index',      'pid' => 1, 'rank' => 1, 'created_at' => now()],
            ['name' => 'rules_add',     'action' => 'rules.store',      'pid' => 9, 'rank' => 2, 'created_at' => now()],
            ['name' => 'rules_add',     'action' => 'rules.create',     'pid' => 9, 'rank' => 2, 'created_at' => now()],
            ['name' => 'rules_del',     'action' => 'rules.destroy',    'pid' => 9, 'rank' => 2, 'created_at' => now()],
            ['name' => 'rules_edit',    'action' => 'rules.update',     'pid' => 9, 'rank' => 2, 'created_at' => now()],
            ['name' => 'rules_edit',    'action' => 'rules.edit',       'pid' => 9, 'rank' => 2, 'created_at' => now()],
            ['name' => 'rules_show',    'action' => 'rules.show',       'pid' => 9, 'rank' => 2, 'created_at' => now()],
        ]);

        // Group
        // $rules = Rule::where('pid', '<>', 0)->get(['id']);
        // $rules_id = implode(',', $rules->id);
        // Group::create([
        //     'name' => 'administrator',
        //     'rules_id' => $rules_id,
        //     'description' => 'Administrator组 拥有后台所有权限',
        //     'status' => true,
        //     'menu' => '',
        // ]);

        // Administrator
        User::factory()->count(20)->state(new Sequence(
            ['group_id' => 1],
            ['group_id' => 2],
        ))->create();

        // // @brevis-ng: Add the first IP to whitelist
        // \App\Models\Config::create([
        //     'operator' => 'Administrator',
        //     'meta_key' => 'ip_whitelist',
        //     'meta_value' => '127.0.0.1,180.232.113.168',
        //     'meta_desc' => '白名单IP地址',
        // ]);
    }
}
