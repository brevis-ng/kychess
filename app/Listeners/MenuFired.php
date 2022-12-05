<?php

namespace App\Listeners;

use App\Events\OnMenuChanged;
use App\Models\Permission;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MenuFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OnMenuChanged  $event
     * @return void
     */
    public function handle(OnMenuChanged $event)
    {
        $roles = Permission::find($event->permission_id)->roles;
        foreach ( $roles as $role ) {
            $new_menu = $role->menu;

            $columns = ['permissions.id', 'pid', 'title', 'icon', 'href', 'target'];
            $where = [['level', '<', 2], ['status', true]];
            
            $permissions = $role->permissions()->where($where)->get($columns)->toArray();
            $parents = Permission::where('level', 0)->where('status', true)->get($columns)->toArray();
            $permissions = array_merge($permissions, $parents);
            unset($permissions['pivot']);

            $menu_info = $this->buildMenuChild(0, $permissions);

            $new_menu['menuInfo'] = $menu_info;

            $role->menu = $new_menu;

            $role->save();
        }
    }

    /**
     * Build menuInfo
     * 
     * @param int $pid
     * @param array $permissions
     */
    private function buildMenuChild($pid, $permissions)
    {
        $menu_tree = [];
        foreach ($permissions as $menu) {
            if ($pid == $menu['pid']) {
                $node = (array)$menu;
                $child = $this->buildMenuChild($menu['id'], $permissions);
                if (!empty($child)) {
                    $node['child'] = $child;
                }
                $menu_tree[] = $node;
            }
        }
        return $menu_tree;
    }
}
