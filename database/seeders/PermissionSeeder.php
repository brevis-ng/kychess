<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            // *
            ['pid' => 0, 'title' => 'menu', 'icon' => 'fa fa-gears', 'href' => '', 'level' => 0, 'level' => 0, 'action' => 'menu.viewAny', 'created_at' => now()],
            // *----*
            ['pid' => 1, 'title' => 'manager', 'icon' => 'fa fa-tasks', 'href' => '', 'level' => 0, 'action' => 'menu.manager', 'created_at' => now()],
            // *----*----*
            ['pid' => 2, 'title' => 'admin.index', 'icon' => 'fa fa-user', 'href' => route('admin.index'), 'level' => 1, 'action' => 'admin.viewAny', 'created_at' => now()],
            ['pid' => 3, 'title' => 'admin.show', 'icon' => 'fa fa-eye', 'href' => '', 'level' => 2, 'action' => 'admin.view', 'created_at' => now()],
            ['pid' => 3, 'title' => 'admin.create', 'icon' => 'fa fa-user-plus', 'href' => '', 'level' => 2, 'action' => 'admin.create', 'created_at' => now()],
            ['pid' => 3, 'title' => 'admin.edit', 'icon' => 'fa fa-pencil', 'href' => '', 'level' => 2, 'action' => 'admin.update', 'created_at' => now()],
            ['pid' => 3, 'title' => 'admin.destroy', 'icon' => 'fa fa-trash', 'href' => '', 'level' => 2, 'action' => 'admin.destroy', 'created_at' => now()],
            // *----*----*
            ['pid' => 2, 'title' => 'roles.index', 'icon' => 'fa fa-group', 'href' => route('roles.index'), 'level' => 1, 'action' => 'roles.viewAny', 'created_at' => now()],
            ['pid' => 8, 'title' => 'roles.show', 'icon' => 'fa fa-eye', 'href' => '', 'level' => 2, 'action' => 'roles.view', 'created_at' => now()],
            ['pid' => 8, 'title' => 'roles.create', 'icon' => 'fa fa-user-plus', 'href' => '', 'level' => 2, 'action' => 'roles.create', 'created_at' => now()],
            ['pid' => 8, 'title' => 'roles.edit', 'icon' => 'fa fa-pencil', 'href' => '', 'level' => 2, 'action' => 'roles.update', 'created_at' => now()],
            ['pid' => 8, 'title' => 'roles.destroy', 'icon' => 'fa fa-trash', 'href' => '', 'level' => 2, 'action' => 'roles.destroy', 'created_at' => now()],
            // *----*----*
            ['pid' => 2, 'title' => 'permission.index', 'icon' => 'fa fa-gavel', 'href' => route('permissions.index'), 'level' => 1, 'action' => 'permission.viewAny', 'created_at' => now()],
            ['pid' => 13, 'title' => 'permission.show', 'icon' => 'fa fa-eye', 'href' => '', 'level' => 2, 'action' => 'permission.view', 'created_at' => now()],
            ['pid' => 13, 'title' => 'permission.create', 'icon' => 'fa fa-plus', 'href' => '', 'level' => 2, 'action' => 'permission.create', 'created_at' => now()],
            ['pid' => 13, 'title' => 'permission.edit', 'icon' => 'fa fa-pencil', 'href' => '', 'level' => 2, 'action' => 'permission.update', 'created_at' => now()],
            ['pid' => 13, 'title' => 'permission.destroy', 'icon' => 'fa fa-trash', 'href' => '', 'level' => 2, 'action' => 'permission.destroy', 'created_at' => now()],
            // *----*
            ['pid' => 1, 'title' => 'activity.name', 'icon' => 'fa fa-gamepad', 'href' => '', 'level' => 0, 'action' => 'menu.activity', 'created_at' => now()],
            // *----*----*
            ['pid' => 18, 'title' => 'activity.index', 'icon' => 'fa fa-puzzle-piece', 'href' => route('activity.index'), 'level' => 1, 'action' => 'activity.viewAny', 'created_at' => now()],
            ['pid' => 18, 'title' => 'activity.show', 'icon' => 'fa fa-eye', 'href' => '', 'level' => 2, 'action' => 'activity.view', 'created_at' => now()],
            ['pid' => 18, 'title' => 'activity.create', 'icon' => 'fa fa-user-plus', 'href' => '', 'level' => 2, 'action' => 'activity.create', 'created_at' => now()],
            ['pid' => 18, 'title' => 'activity.edit', 'icon' => 'fa fa-pencil', 'href' => '', 'level' => 2, 'action' => 'activity.update', 'created_at' => now()],
            ['pid' => 18, 'title' => 'activity.destroy', 'icon' => 'fa fa-trash', 'href' => '', 'level' => 2, 'action' => 'activity.destroy', 'created_at' => now()],
            // *----*
            ['pid' => 1, 'title' => 'system', 'icon' => 'fa fa-cogs', 'href' => '', 'level' => 0, 'action' => 'menu.system', 'created_at' => now()],
            // *----*----*
            ['pid' => 24, 'title' => 'log', 'icon' => 'fa fa-code-fork', 'href' => route('home.log'), 'level' => 1, 'action' => 'log.viewAny', 'created_at' => now()],
            ['pid' => 24, 'title' => 'whitelist', 'icon' => 'fa fa-shield', 'href' => route('home.whitelist'), 'level' => 1, 'action' => 'whitelist.viewAny', 'created_at' => now()],
            ['pid' => 24, 'title' => 'announcement', 'icon' => 'fa fa-send', 'href' => route('home.announcement'), 'level' => 1, 'action' => 'announcement.viewAny', 'created_at' => now()],
        ]);
    }
}
