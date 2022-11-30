<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ( $request->has('type') && hash_equals('menu', $request->query('type'))) {
            $current_page = $request->filled('page') ? intval($request->input('page')) : 1;
            $per_page = $request->filled('limit') ? intval($request->input('limit')) : 20;
    
            $where = [];
            if ( $request->filled('searchParams') ) {
                $params = json_decode($request->input('searchParams'), true);
                $where[] = array( 'username', 'LIKE', '%' . $params['username'] . '%');
                $where[] = array( 'name', 'LIKE', '%' . $params['name'] . '%');
            }
    
            $users = User::where($where)->orderBy('id')->paginate($per_page, ['*'], 'page', $current_page)->toArray();

            foreach ($users['data'] as $key => $user) {
                $users['data'][$key]['role_id'] = Role::find($user['role_id'])->name;
            }

            return response()->json([
                'code' => 0,
                'msg' => 'success',
                'count' => $users['total'],
                'data' => $users['data']
            ]);
        }

        return view('admin.admin.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
        if ( $request->user()->cannot('delete', User::find($id)) ) {
            return response()->json(['code' => 403, 'msg' => trans('home.cannot', ['permission' => trans('home.admin.destroy')])]);
        }

        if ( $request->filled('ids') ) {
            $ids = $request->input('ids');
            $count = User::destroy($ids);
            if ( $count == 0 ) {
                return response()->json(['code' => 400, 'msg' => trans('home.delete.no')]);
            } else {
                $failed = count($ids) - $count;
                return response()->json(['code' => 200, 'msg' => trans('home.delete.ok') . " | $count success $failed failed"]);
            }
        } else {
            $count = User::destroy($id);
            
            if ( $count == 1 ) {
                return response()->json(['code' => 200, 'msg' => trans('home.delete.ok')]);
            } else {
                return response()->json(['code' => 400, 'msg' => trans('home.delete.no')]);
            }
        }
    }
}
