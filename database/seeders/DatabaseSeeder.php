<?php

namespace Database\Seeders;

use App\Models\Config;
use App\Models\Permission;
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
            ['pid' => 0, 'title' => 'menu', 'icon' => 'fa fa-gears', 'href' => '', 'level' => 0, 'level' => 0, 'action' => 'menu.viewAny', 'created_at' => now()],

            ['pid' => 1, 'title' => 'manager', 'icon' => 'fa fa-tasks', 'href' => '', 'level' => 0, 'action' => 'menu.manager', 'created_at' => now()],

            ['pid' => 2, 'title' => 'admin.index', 'icon' => 'fa fa-user', 'href' => route('admin.index'), 'level' => 1, 'action' => 'admin.viewAny', 'created_at' => now()],
            ['pid' => 3, 'title' => 'admin.show', 'icon' => 'fa fa-eye', 'href' => '', 'level' => 2, 'action' => 'admin.view', 'created_at' => now()],
            ['pid' => 3, 'title' => 'admin.create', 'icon' => 'fa fa-user-plus', 'href' => '', 'level' => 2, 'action' => 'admin.create', 'created_at' => now()],
            ['pid' => 3, 'title' => 'admin.store', 'icon' => 'fa fa-user-plus', 'href' => '', 'level' => 2, 'action' => 'admin.create', 'created_at' => now()],
            ['pid' => 3, 'title' => 'admin.edit', 'icon' => 'fa fa-pencil', 'href' => '', 'level' => 2, 'action' => 'admin.update', 'created_at' => now()],
            ['pid' => 3, 'title' => 'admin.update', 'icon' => 'fa fa-pencil', 'href' => '', 'level' => 2, 'action' => 'admin.update', 'created_at' => now()],
            ['pid' => 3, 'title' => 'admin.destroy', 'icon' => 'fa fa-trash', 'href' => '', 'level' => 2, 'action' => 'admin.destroy', 'created_at' => now()],

            ['pid' => 2, 'title' => 'roles.index', 'icon' => 'fa fa-group', 'href' => route('roles.index'), 'level' => 1, 'action' => 'roles.viewAny', 'created_at' => now()],
            ['pid' => 10, 'title' => 'roles.show', 'icon' => 'fa fa-eye', 'href' => '', 'level' => 2, 'action' => 'roles.view', 'created_at' => now()],
            ['pid' => 10, 'title' => 'roles.create', 'icon' => 'fa fa-user-plus', 'href' => '', 'level' => 2, 'action' => 'roles.create', 'created_at' => now()],
            ['pid' => 10, 'title' => 'roles.store', 'icon' => 'fa fa-user-plus', 'href' => '', 'level' => 2, 'action' => 'roles.create', 'created_at' => now()],
            ['pid' => 10, 'title' => 'roles.edit', 'icon' => 'fa fa-pencil', 'href' => '', 'level' => 2, 'action' => 'roles.update', 'created_at' => now()],
            ['pid' => 10, 'title' => 'roles.update', 'icon' => 'fa fa-pencil', 'href' => '', 'level' => 2, 'action' => 'roles.update', 'created_at' => now()],
            ['pid' => 10, 'title' => 'roles.destroy', 'icon' => 'fa fa-trash', 'href' => '', 'level' => 2, 'action' => 'roles.destroy', 'created_at' => now()],

            ['pid' => 2, 'title' => 'permission.index', 'icon' => 'fa fa-gavel', 'href' => route('permissions.index'), 'level' => 1, 'action' => 'permission.viewAny', 'created_at' => now()],
            ['pid' => 17, 'title' => 'permission.show', 'icon' => 'fa fa-eye', 'href' => '', 'level' => 2, 'action' => 'permission.view', 'created_at' => now()],
            ['pid' => 17, 'title' => 'permission.create', 'icon' => 'fa fa-plus', 'href' => '', 'level' => 2, 'action' => 'permission.create', 'created_at' => now()],
            ['pid' => 17, 'title' => 'permission.store', 'icon' => 'fa fa-plus', 'href' => '', 'level' => 2, 'action' => 'permission.create', 'created_at' => now()],
            ['pid' => 17, 'title' => 'permission.edit', 'icon' => 'fa fa-pencil', 'href' => '', 'level' => 2, 'action' => 'permission.update', 'created_at' => now()],
            ['pid' => 17, 'title' => 'permission.update', 'icon' => 'fa fa-pencil', 'href' => '', 'level' => 2, 'action' => 'permission.update', 'created_at' => now()],
            ['pid' => 17, 'title' => 'permission.destroy', 'icon' => 'fa fa-trash', 'href' => '', 'level' => 2, 'action' => 'permission.destroy', 'created_at' => now()],
        ]);

        // Role
        $role = Role::create([
            'name' => 'Administrator',
            'description' => 'Administrator组 拥有后台所有权限',
            'menu' => $this->createMenu(),
        ]);

        $permissions = Permission::where('level', 1)->orWhere('level', 2)->pluck('id')->toArray();
        $role->permissions()->attach($permissions, ['created_at' => now()]);

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

    private function createMenu()
    {
        $homeInfo = [
	        "title"=> "首页",
	        "href"=> route('home.dashboard'),
        ];
        $logoInfo = [
	        "title"=> "后台管理",
	        "image"=> "/layuimini/images/logo.png"
        ];
        $menuInfo = $this->getMenuList();
        $systemInit = [
            "homeInfo" => $homeInfo,
            "logoInfo" => $logoInfo,
            "menuInfo" => $menuInfo,
        ];

        return $systemInit;
    }

    // 获取菜单列表
    private function getMenuList(){
        $menuList = DB::table('permissions')
            ->select(['id','pid','title','icon','href','target'])
            ->where('status', 1)
            ->where('level', '<', 2)
            ->orderBy('id')
            ->get();
        $menuList = $this->buildMenuChild(0, $menuList);
        return $menuList;
    }

    //递归获取子菜单
    private function buildMenuChild($pid, $menuList){
        $treeList = [];
        foreach ($menuList as $v) {
            if ($pid == $v->pid) {
                $node = (array)$v;
                $child = $this->buildMenuChild($v->id, $menuList);
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
