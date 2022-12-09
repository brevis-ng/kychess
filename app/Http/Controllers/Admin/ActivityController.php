<?php

namespace App\Http\Controllers\Admin;

use App\Events\OnChanged;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

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
        if ( $request->user()->cannot('create', Activity::class) ) {
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
        if ( $request->user()->cannot('create', Activity::class) ) {
            return view('admin.403', ['message' => trans('home.cannot', ['permission' => trans('home.activity.create')])]);
        }

        $validated = $request->validate([
            'title' => 'required|string',
            'forms' => 'required',
            'content' => 'required',
            'repetition_name' => Rule::requiredIf( ! $request->boolean('repeatable') ),
        ]);
        $validated['poster'] = $request->input('poster');
        $validated['sort'] = $request->filled('sort') ? $request->input('sort') : Activity::all()->count() + 1;
        $validated['repeatable'] = $request->boolean('repeatable');
        $validated['repetition_name'] = $request->input('repetition_name');
        $validated['active'] = $request->boolean('active');

        $activity = Activity::create($validated);

        if ( $activity ) {
            Cache::forget('newest_poster_path');

            event(new OnChanged('create', "Create permission id [$activity->id]"));

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
        if ( $request->user()->cannot('update', Activity::find($id)) ) {
            return view('admin.403', ['message' => trans('home.cannot', ['permission' => trans('home.activity.edit')])]);
        }

        return view('admin.activity.edit', ['activity' => Activity::find($id)]);
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
        if ( $request->user()->cannot('update', Activity::find($id)) ) {
            return view('admin.403', ['message' => trans('home.cannot', ['permission' => trans('home.activity.edit')])]);
        }

        $validated = $request->validate([
            'title' => 'required|string',
            'forms' => 'required',
            'content' => 'required',
            'repetition_name' => Rule::requiredIf( ! $request->boolean('repeatable') ),
        ]);
        $validated['poster'] = $request->input('poster');
        $validated['sort'] = $request->filled('sort') ? $request->input('sort') : Activity::all()->count() + 1;
        $validated['repeatable'] = $request->boolean('repeatable');
        $validated['repetition_name'] = $request->input('repetition_name');
        $validated['active'] = $request->boolean('active');

        $count = Activity::find($id)->update($validated);

        if ( $count == 1 ) {
            event(new OnChanged('update', "Update activity id [$id]"));

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
        if ( $request->user()->cannot('delete', Activity::find($id)) ) {
            return view('admin.403', ['message' => trans('home.cannot', ['permission' => trans('home.activity.destroy')])]);
        }

        if ( $request->filled('ids') ) {
            $ids = $request->input('ids');
            $count = Activity::destroy($ids);

            if ( $count == 0 ) {
                return response()->json(['code' => 400, 'msg' => trans('home.delete.no')]);
            } else {
                $failed = count($ids) - $count;
                return response()->json(['code' => 200, 'msg' => trans('home.delete.ok') . " | $count success $failed failed"]);
            }
        } else {
            $count = Activity::destroy($id);
            
            if ( $count == 1 ) {
                return response()->json(['code' => 200, 'msg' => trans('home.delete.ok')]);
            } else {
                return response()->json(['code' => 400, 'msg' => trans('home.delete.no')]);
            }
        }
    }
}
