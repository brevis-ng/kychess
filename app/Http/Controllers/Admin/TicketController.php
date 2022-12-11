<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pending(Request $request)
    {
        if ( $request->user()->cannot('viewAny', Ticket::class) ) {
            return view('admin.403', ['message' => trans('home.cannot', ['permission' => trans('home.ticket.index')])]);
        }

        if ( $request->has('type') && hash_equals('menu', $request->query('type'))) {
            $current_page = $request->filled('page') ? intval($request->input('page')) : 1;
            $per_page = $request->filled('limit') ? intval($request->input('limit')) : 20;
    
            $tickets = Ticket::paginate($per_page, ['*'], 'page', $current_page)->toArray();

            return response()->json([
                'code' => 0,
                'msg' => 'success',
                'count' => $tickets['total'],
                'data' => $tickets['data']
            ]);
        }

        return view('admin.ticket.pending');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
