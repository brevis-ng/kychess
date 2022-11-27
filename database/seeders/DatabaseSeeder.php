<?php

namespace Database\Seeders;

use App\Models\Config;
use App\Models\Role;
use App\Models\User;
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
        // Permissions seed
        DB::table('permissions')->insert([
            ['name' => 'admin.config', 'action' => '', 'pid' => 0, 'rank' => 0, 'created_at' => now()],
            
            ['name' => 'admin.index',   'action' => 'admin.viewAny',  'pid' => 1, 'rank' => 1, 'created_at' => now()],
            ['name' => 'admin.show',    'action' => 'admin.view',     'pid' => 2, 'rank' => 2, 'created_at' => now()],
            ['name' => 'admin.create',  'action' => 'admin.create',   'pid' => 2, 'rank' => 2, 'created_at' => now()],
            ['name' => 'admin.update',  'action' => 'admin.update',   'pid' => 2, 'rank' => 2, 'created_at' => now()],
            ['name' => 'admin.destroy', 'action' => 'admin.delete',   'pid' => 2, 'rank' => 2, 'created_at' => now()],

            ['name' => 'roles.index',   'action' => 'roles.viewAny',  'pid' => 1, 'rank' => 1, 'created_at' => now()],
            ['name' => 'roles.show',    'action' => 'roles.view',     'pid' => 7, 'rank' => 2, 'created_at' => now()],
            ['name' => 'roles.create',  'action' => 'roles.create',   'pid' => 7, 'rank' => 2, 'created_at' => now()],
            ['name' => 'roles.update',  'action' => 'roles.update',   'pid' => 7, 'rank' => 2, 'created_at' => now()],
            ['name' => 'roles.destroy', 'action' => 'roles.delete',   'pid' => 7, 'rank' => 2, 'created_at' => now()],

            ['name' => 'permission.index',   'action' => 'permission.viewAny',  'pid' => 1,  'rank' => 1, 'created_at' => now()],
            ['name' => 'permission.show',    'action' => 'permission.view',     'pid' => 12, 'rank' => 2, 'created_at' => now()],
            ['name' => 'permission.create',  'action' => 'permission.create',   'pid' => 12, 'rank' => 2, 'created_at' => now()],
            ['name' => 'permission.update',  'action' => 'permission.update',   'pid' => 12, 'rank' => 2, 'created_at' => now()],
            ['name' => 'permission.destroy', 'action' => 'permission.delete',   'pid' => 12, 'rank' => 2, 'created_at' => now()],
        ]);

        // Role
        $role = Role::create([
            'name' => 'Administrator',
            'description' => 'Administrator组 拥有后台所有权限',
            'menu' => $this->createMenu([1, 2, 7, 12]),
        ]);

        // Administrator
        User::create([
            'username' => 'admin',
            'name' => 'Administrator',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'status' => true,
            'role_id' => $role->id
        ]);

        // Add the first IP to whitelist
        Config::create([
            'operator' => 'Administrator',
            'meta_key' => 'ip_whitelist',
            'meta_value' => '127.0.0.1,180.232.113.168',
            'meta_desc' => '白名单IP地址',
        ]);
    }

    private function createMenu($ids)
    {
        $menus = [];
        foreach ( $ids as $id ) {
            $permission = DB::table('permissions')->find($id);
            $menus[] = [
                'id' => $permission->id,
                'pid' => $permission->pid,
                'title' => $permission->name,
                'href' => '',
                'target' => '_self',
                'icon' => 'fa fa-asterisk',
            ];
        }
        $homeInfo = [
	        "title"=> "首页",
	        "href"=> "#"
        ];
        $logoInfo = [
	        "title"=> "后台管理",
	        "image"=> "/static/images/logo.png"
        ];
        $menuInfo = $this->buildMenuChild(0, $menus);
        $systemInit = [
            'homeInfo' => $homeInfo,
            'logoInfo' => $logoInfo,
            'menuInfo' => $menuInfo,
        ];

        return json_encode($systemInit);
    }

    private function buildMenuChild($pid, $menuList){
        $treeList = [];
        foreach ($menuList as $v) {
            if ($pid == $v['pid']) {
                $node = (array)$v;
                $child = $this->buildMenuChild($v['id'], $menuList);
                if (!empty($child)) {
                    $node['child'] = $child;
                }
                // todo 后续此处加上用户的权限判断
                $treeList[] = $node;
            }
        }
        return $treeList;
    }
}
