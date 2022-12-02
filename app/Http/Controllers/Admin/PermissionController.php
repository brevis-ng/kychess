<?php

namespace App\Http\Controllers\Admin;

use App\Events\OnChanged;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        if ( $request->user()->cannot('viewAny', Permission::class) ) {
            return view('admin.403', ['message' => trans('home.cannot', ['permission' => trans('home.permission.show')])]);
        }

        if ( $request->has('type') && hash_equals('menu', $request->query('type'))) {
            $current_page = $request->filled('page') ? intval($request->input('page')) : 1;
            $per_page = $request->filled('limit') ? intval($request->input('limit')) : 20;
    
            $permission = Permission::paginate($per_page, ['*'], 'page', $current_page)->toArray();

            return response()->json([
                'code' => 0,
                'msg' => 'success',
                'count' => $permission['total'],
                'data' => $permission['data']
            ]);
        }

        return view('admin.permission.index');
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
            return view('admin.403', ['message' => trans('home.cannot', ['permission' => trans('home.permission.create')])]);
        }

        return view('admin.permission.create', [
            'permissions' => Permission::where('status', true)->where('level', '<', 2)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( $request->user()->cannot('create', Permission::class) ) {
            return view('admin.403', ['message' => trans('home.cannot', ['permission' => trans('home.permission.create')])]);
        }

        $validated = $request->validate([
            'pid' => ['required'],
            'title' => ['required'],
            'level' => ['required', 'integer'],
            'action' => ['required'],
        ]);

        $validated['status'] = $request->input('status', 'off') == 'on' ? true : false;

        $request->has('icon') ? $validated['icon'] = 'fa ' . $request->input('icon') : null;

        $request->has('href') ? $validated['href'] = $request->input('href') : '';

        $permission = Permission::create($validated);

        if ( $permission ) {
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
        if ( $request->user()->cannot('update', Permission::find($id)) ) {
            return view('admin.403', ['message' => trans('home.cannot', ['permission' => trans('home.admin.edit')])]);
        }

        $permission = Permission::find($id);
        $permissions = Permission::where('status', true)->where('level', '<', 2)->get(['id', 'title']);

        return view('admin.permission.edit', [
            'permission' => $permission,
            'permissions' => $permissions
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
        if ( $request->user()->cannot('update', Permission::find($id)) ) {
            return view('admin.403', ['message' => trans('home.cannot', ['permission' => trans('home.admin.edit')])]);
        }

        $validated = $request->validate([
            'pid' => ['required'],
            'title' => ['required'],
            'level' => ['required', 'integer'],
            'action' => ['required'],
        ]);

        $validated['status'] = $request->input('status', 'off') == 'on' ? true : false;

        $request->has('icon') ? $validated['icon'] = 'fa ' . $request->input('icon') : null;

        $request->has('href') ? $validated['href'] = $request->input('href') : '';

        $count = Permission::find($id)->update($validated);

        if ( $count == 1 ) {
            event(new OnChanged('update', "Update permission id [$id]"));
            return response()->json(['code' => 200, 'msg' => trans('home.edit.ok')]);
        } else {
            return response()->json(['code' => 400, 'msg' => trans('home.edit.no')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
