<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu = [
            'homeInfo' => [
                'title' => 'Dashboard',
                'href' => route('home.dashboard'),
            ],
            'logoInfo' => [
                'title' => config('app.name'),
	            'image' => '/layuimini/images/logo.png'
            ],
            'menuInfo' => $this->getMenuList(),
        ];

        // Create administrator role
        DB::table('roles')->insert([
            'name' => 'Administrator',
            'description' => 'Administrator组 拥有后台所有权限',
            'menu' => json_encode($menu),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert pivot table
        $permissions = DB::table('permissions')->whereIn('level', [1, 2], 'or')->pluck('id')->toArray();
        $attach = [];
        foreach ( $permissions as $permission ) {
            $attach[] = ['permission_id' => $permission, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()];
        }
        DB::table('permission_role')->insert($attach);
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
