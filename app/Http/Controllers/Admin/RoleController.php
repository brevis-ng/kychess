<?php

namespace App\Http\Controllers\Admin;

use App\Events\OnChanged;
use App\Events\OnMenuChanged;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ( $request->user()->cannot('viewAny', Role::class) ) {
            return view('admin.403', ['message' => trans('home.cannot', ['permission' => trans('home.permission.show')])]);
        }

        if ( $request->has('type') && hash_equals('menu', $request->query('type'))) {
            $current_page = $request->filled('page') ? intval($request->input('page')) : 1;
            $per_page = $request->filled('limit') ? intval($request->input('limit')) : 20;
    
            $roles = Role::paginate($per_page, ['*'], 'page', $current_page)->toArray();

            return response()->json([
                'code' => 0,
                'msg' => 'success',
                'count' => $roles['total'],
                'data' => $roles['data']
            ]);
        }

        return view('admin.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ( $request->user()->cannot('create', Permission::class) ) {
            return view('admin.403', ['message' => trans('home.cannot', ['permission' => trans('home.roles.create')])]);
        }

        $permissions = Permission::where('status', true)->where('pid', 0)->get()->toArray();
        $tree_data = $this->treeable($permissions, []);
        $tree_data = json_encode($tree_data);

        return view('admin.role.create', compact('tree_data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( $request->user()->cannot('create', Role::class) ) {
            return view('admin.403', ['message' => trans('home.cannot', ['permission' => trans('home.roles.create')])]);
        }

        $validated = $request->validate([
            'name' => 'required',
            'description' => 'nullable|string',
            'permission_ids' => 'required',
            'menu_ids' => 'required',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'menu' => [
                'homeInfo' => ['title' => '首页', 'href' => route('home.dashboard')],
                'logoInfo' => ['title' => '后台', 'image' => '/layuimini/images/logo.png'],
                'menuInfo' => [],
            ]
        ]);

        if ( $role ) {
            $permission_ids = explode(',', $validated['permission_ids']);
            $role->permissions()->attach($permission_ids, ['created_at' => now(), 'updated_at' => now()]);
    
            event(new OnChanged('create', "Create role id [$role->id]"));
            event(new OnMenuChanged(null, $role->id));

            return response()->json(['code' => 200, 'msg' => trans('home.add.ok')]);
        } else {
            return response()->json(['code' => 400, 'msg' => trans('home.add.no')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if ( $request->user()->cannot('update', Role::find($id)) ) {
            return view('admin.403', ['message' => trans('home.cannot', ['permission' => trans('home.roles.edit')])]);
        }

        $role = Role::find($id);

        $permissions = Permission::where('status', true)->where('pid', 0)->get()->toArray();

        $belongto_role = $role->permissions()->pluck('permissions.id')->toArray();
        $tree_data = $this->treeable($permissions, $belongto_role);
        $tree_data = json_encode($tree_data);

        return view('admin.role.edit', [
            'role' => $role,
            'tree_data' => $tree_data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ( $request->user()->cannot('update', Role::find($id)) ) {
            return view('admin.403', ['message' => trans('home.cannot', ['permission' => trans('home.roles.edit')])]);
        }

        $validated = $request->validate([
            'name' => 'required',
            'description' => 'nullable|string',
            'permission_ids' => 'required',
            'menu_ids' => 'required',
        ]);

        if ( $role = Role::find($id) ) {
            $permission_ids = explode(',', $validated['permission_ids']);
            $role->permissions()->syncWithPivotValues($permission_ids, ['created_at' => now(), 'updated_at' => now()]);

            event(new OnChanged('create', "Edit role id [$role->id]"));
            event(new OnMenuChanged(null, $role->id));

            return response()->json(['code' => 200, 'msg' => trans('home.edit.ok')]);
        } else {
            return response()->json(['code' => 400, 'msg' => trans('home.edit.no')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ( $request->user()->cannot('delete', Permission::find($id)) ) {
            return view('admin.403', ['message' => trans('home.cannot', ['permission' => trans('home.permission.destroy')])]);
        }

        if ( $request->filled('ids') ) {
            $ids = $request->input('ids');
            $count = Role::destroy($ids);
            if ( $count == 0 ) {
                return response()->json(['code' => 400, 'msg' => trans('home.delete.no')]);
            } else {
                $failed = count($ids) - $count;
                return response()->json(['code' => 200, 'msg' => trans('home.delete.ok') . " | $count success $failed failed"]);
            }
        } else {
            $count = Role::destroy($id);
            
            if ( $count == 1 ) {
                return response()->json(['code' => 200, 'msg' => trans('home.delete.ok')]);
            } else {
                return response()->json(['code' => 400, 'msg' => trans('home.delete.no')]);
            }
        }
    }

    /**
     * Generate tree
     * 
     * @param array $permissions
     * @param array $belongto_user
     */
    protected function treeable($permissions, $belongto_role)
    {
        $treeable=[];
        $i = 0;
        foreach ($permissions as $k => $permission){
            $treeable[$i]=[
                'title' => trans('home.' . $permission['title']),
                'id' => $permission['id'],
                'field' => '',
                'spread' =>true,
                'level' => $permission['level'],
            ];

            if ( $permission['level'] == 2 && in_array($permission['id'], $belongto_role) ) {
                $treeable[$i]['checked'] = true;
            } else {
                $treeable[$i]['checked'] = false;
            }

            $childrens = Permission::where('pid', $permission['id'])->where('status', true)->get()->toArray();

            if ( ! empty($childrens) && is_array($childrens) ) {
                $treeable[$i]['children'] = $this->treeable($childrens, $belongto_role);
            }
            $i += 1;
        }
        return $treeable;
    }
}
