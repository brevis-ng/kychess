<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TicketExport;
use App\Http\Controllers\Controller;
use App\Models\Activity;
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
        if ($request->user()->cannot("viewAny", Ticket::class)) {
            return view("admin.403", ["message" => trans("home.cannot", ["permission" => trans("home.ticket.index")])]);
        }

        if ( $request->has("type") && hash_equals("menu", $request->query("type")) ) {
            $current_page = $request->filled("page") ? intval($request->input("page")) : 1;
            $per_page = $request->filled("limit") ? intval($request->input("limit")) : 20;

            $where = [["status", Ticket::PENDING]];
            if ($request->filled("searchParams")) {
                $params = json_decode($request->input("searchParams"), true);
                $where[] = ["username", "LIKE", "%" . $params["username"] . "%"];
                if ($params["activity_id"] != "") {
                    $where[] = ["activity_id", $params["activity_id"]];
                }
            }
            
            $tickets = Ticket::where($where)
                ->with(['activity'])
                ->orderBy("created_at", "desc")
                ->paginate($per_page, ["*"], "page", $current_page)
                ->toArray();

            return response()->json([
                "code" => 0,
                "msg" => "success",
                "count" => $tickets["total"],
                "data" => $tickets["data"],
            ]);
        }

        return view("admin.ticket.pending", [
            "activities" => Activity::all(["id", "title"]),
        ]);
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
     * Update the ticket status
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function accept(Request $request)
    {
        if ($request->user()->cannot("update", Ticket::class)) {
            return view("admin.403", ["message" => trans("home.cannot", ["permission" => trans("home.ticket.accepted")])]);
        }

        if ( $request->filled('ids') ) {
            $ids = $request->input('ids');

            $count = Ticket::where('status', Ticket::PENDING)
                ->whereIn('id', $ids)
                ->update(['status' => Ticket::ACCEPTED]);
            
            if ( $count == 0 ) {
                return response()->json(['code' => 400, 'msg' => trans('home.accept.no')]);
            } else {
                $failed = count($ids) - $count;
                return response()->json(['code' => 200, 'msg' => trans('home.accept.ok') . " | $count success $failed failed"]);
            }
        } else {
            return response()->json(['code' => 200, 'msg' => trans('home.accept.no')]);
        }
    }

    /**
     * Update the ticket status
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reject(Request $request)
    {
        if ($request->user()->cannot("update", Ticket::class)) {
            return view("admin.403", ["message" => trans("home.cannot", ["permission" => trans("home.ticket.accepted")])]);
        }

        if ( $request->filled('ids') ) {
            $ids = $request->input('ids');

            $count = Ticket::where('status', Ticket::PENDING)
                ->whereIn('id', $ids)
                ->update(['status' => Ticket::REJECTED]);
            
            if ( $count == 0 ) {
                return response()->json(['code' => 400, 'msg' => trans('home.reject.no')]);
            } else {
                $failed = count($ids) - $count;
                return response()->json(['code' => 200, 'msg' => trans('home.reject.ok') . " | $count success $failed failed"]);
            }
        } else {
            return response()->json(['code' => 200, 'msg' => trans('home.reject.no')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        if ( $request->has("type") && hash_equals("options", $request->query("type")) ) {
            return view('admin.ticket.options');
        }

        $exporter = new TicketExport();

        if ( $request->has('status') ) {
            $exporter->setStatus( array_keys($request->input('status')) );
        }
        if (
            $request->filled('submit-start') ||
            $request->filled('submit-end')
        ) {
            $exporter->setSubmitTime(
                $request->input('submit-start'),
                $request->input('submit-end')
            );
        }

        return $exporter->download('data.xlsx');
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
