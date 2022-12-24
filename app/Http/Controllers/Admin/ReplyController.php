<?php

namespace App\Http\Controllers\Admin;

use App\Events\OnMenuChanged;
use App\Http\Controllers\Controller;
use App\Models\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ( $request->user()->cannot('viewAny', Reply::class) ) {
            return view('admin.403', ['message' => trans('home.cannot', ['permission' => trans('home.reply.setting')])]);
        }

        if ( $request->has('type') && hash_equals('menu', $request->query('type'))) {
            $replies = Reply::all()->toArray();

            return response()->json([
                'code' => 0,
                'msg' => 'success',
                'count' => count($replies),
                'data' => $replies
            ]);
        }

        return view('admin.reply.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ( $request->user()->cannot('create', Reply::class) ) {
            return view('admin.403', ['message' => trans('home.cannot', ['permission' => trans('home.reply.create')])]);
        }

        return view('admin.reply.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( $request->user()->cannot('create', Reply::class) ) {
            return response()->json([
                'code' => 403,
                'msg' => trans('home.cannot', [
                    'permission' => trans('home.reply.create'),
                ]),
            ]);
        }

        $validated = $request->validate([ 'content' => 'required' ]);

        $reply = Reply::create($validated);

        if ( $reply ) {
            return response()->json(['code' => 200, 'msg' => trans('home.add.ok')]);
        } else {
            return response()->json(['code' => 400, 'msg' => trans('home.add.no')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ( $request->filled('type') ) {
            $replies = Reply::all()->toArray();

            return response()->json([
                'code' => 0,
                'msg' => 'success',
                'count' => count($replies),
                'data' => $replies
            ]);
        }

        return view('admin.reply.show', ['ticket_id' => $id]);
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
        if ( $request->user()->cannot('update', Reply::class) ) {
            return view('admin.403', ['message' => trans('home.cannot', ['permission' => trans('home.reply.edit')])]);
        }

        $reply = Reply::find($id);

        return view('admin.reply.edit', ['reply' => $reply]);
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
        if ( $request->user()->cannot('update', Reply::class) ) {
            return response()->json([
                'code' => 403,
                'msg' => trans('home.cannot', [
                    'permission' => trans('home.reply.update')
                ]),
            ]);
        }

        $reply = Reply::find($id);
        if ( $reply && $request->filled('content')) {
            $reply->content = $request->input('content');
            $reply->save();

            return response()->json([
                'code' => 200,
                'msg' => trans('home.edit.ok'),
            ]);
        }
        return response()->json([
            'code' => 400,
            'msg' => trans('home.edit.no'),
        ]);
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
        if ( $request->user()->cannot('update', Reply::class) ) {
            return response()->json([
                'code' => 403,
                'msg' => trans('home.cannot', [
                    'permission' => trans('home.reply.update')
                ]),
            ]);
        }

        $count = Reply::destroy($id);
        
        if ( $count == 1 ) {
            return response()->json(['code' => 200, 'msg' => trans('home.delete.ok')]);
        } else {
            return response()->json(['code' => 400, 'msg' => trans('home.delete.no')]);
        }
    }
}
