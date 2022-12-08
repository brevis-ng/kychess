<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ( $request->user()->cannot('viewAny', Activity::class) ) {
            return view('admin.403', ['message' => trans('home.cannot', ['permission' => trans('home.activity.show')])]);
        }

        if ( $request->has('type') && hash_equals('menu', $request->query('type'))) {
            $where = [];
            if ( $request->filled('searchParams') ) {
                $params = json_decode($request->input('searchParams'), true);
                $where[] = array( 'title', 'LIKE', '%' . $params['title'] . '%');
            }
    
            $activities = Activity::where($where)->orderBy('id')->get()->toArray();

            return response()->json([
                'code' => 0,
                'msg' => 'success',
                'count' => count($activities),
                'data' => $activities,
            ]);
        }

        return view('admin.activity.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ( $request->user()->cannot('create', User::class) ) {
            return view('admin.403', ['message' => trans('home.cannot', ['permission' => trans('home.activity.create')])]);
        }

        return view('admin.activity.create');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
