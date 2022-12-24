<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TicketExport;
use App\Http\Controllers\Controller;
use App\Jobs\TicketExportJob;
use App\Models\Activity;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

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
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function audited(Request $request)
    {
        if ($request->user()->cannot("viewAny", Ticket::class)) {
            return view("admin.403", ["message" => trans("home.cannot", ["permission" => trans("home.ticket.index")])]);
        }

        if ( $request->has("type") && hash_equals("menu", $request->query("type")) ) {
            $current_page = $request->filled("page") ? intval($request->input("page")) : 1;
            $per_page = $request->filled("limit") ? intval($request->input("limit")) : 20;

            $where = [["status", "<>", Ticket::PENDING]];
            if ($request->filled("searchParams")) {
                $params = json_decode($request->input("searchParams"), true);
                $where[] = ["username", "LIKE", "%" . $params["username"] . "%"];
                if ($params["activity_id"] != "") {
                    $where[] = ["activity_id", $params["activity_id"]];
                }
            }
            
            $tickets = Ticket::where($where)
                ->with(['activity'])
                ->orderBy("updated_at", "desc")
                ->paginate($per_page, ["*"], "page", $current_page)
                ->toArray();

            return response()->json([
                "code" => 0,
                "msg" => "success",
                "count" => $tickets["total"],
                "data" => $tickets["data"],
            ]);
        }

        return view("admin.ticket.audited", [
            "activities" => Activity::all(["id", "title"]),
        ]);
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

            $count = Ticket::where('status', '<>', Ticket::ACCEPTED)
                ->whereIn('id', $ids)
                ->update(['status' => Ticket::ACCEPTED]);
            
            if ( $count == 0 ) {
                return response()->json(['code' => 400, 'msg' => trans('home.accept.no')]);
            } else {
                $failed = count($ids) - $count;
                return response()->json(['code' => 200, 'msg' => trans('home.accept.ok') . " | $count success $failed failed"]);
            }
        } else {
            return response()->json(['code' => 400, 'msg' => trans('home.accept.no')]);
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

            $count = Ticket::where('status', '<>', Ticket::REJECTED)
                ->whereIn('id', $ids)
                ->update(['status' => Ticket::REJECTED]);
            
            if ( $count == 0 ) {
                return response()->json(['code' => 400, 'msg' => trans('home.reject.no')]);
            } else {
                $failed = count($ids) - $count;
                return response()->json(['code' => 200, 'msg' => trans('home.reject.ok') . " | $count success $failed failed"]);
            }
        } else {
            return response()->json(['code' => 400, 'msg' => trans('home.reject.no')]);
        }
    }

    /**
     * Update the ticket
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->user()->cannot("update", Ticket::class)) {
            return response()->json([
                'code' => 403,
                'msg' => trans('home.cannot', [
                    'permission' => trans('home.ticket.edit')
                ]),
            ]);
        }

        if ( $request->filled('id') ) {
            if ( $request->has(['field', 'value']) ) {
                $ticket = Ticket::find($request->input('id'));
                if ( $ticket == null ) {
                    return response()->json(['code' => 400, 'msg' => trans('home.edit.no')]);
                }
                try {
                    $ticket->update([$request->input('field') => $request->input('value')]);
                } catch (\Throwable $th) {
                    return response()->json(['code' => 400, 'msg' => trans('home.edit.no')]);
                }
                return response()->json(['code' => 200, 'msg' => trans('home.edit.ok')]);
            }
        } else {
            return response()->json([
                'code' => 400,
                'msg' => trans('validation.required', ['attribute' => 'ID']),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request  $request)
    {
        if ( $request->has("type") && hash_equals("options", $request->query("type")) ) {
            return view('admin.ticket.options');
        }

        $status = null;
        $submit_start = null;
        $submit_end = null;

        if ( $request->has('status') ) {
            $status = array_keys($request->input('status'));
        }
        if (
            $request->filled('submit-start') ||
            $request->filled('submit-end')
        ) {
            $submit_start = $request->input('submit-start');
            $submit_end = $request->input('submit-end');
        }
        $file_name = config('app.name') . date('YmdHis') . '.xlsx';
        
        $batch = Bus::batch([
            new TicketExportJob($file_name, $status, $submit_start, $submit_end)
            ])->dispatch();
            
        Cache::forever($batch->id, $file_name);
        return response()->json([
            'code' => 200,
            'msg' => '',
            'batchId' => $batch->id,
            'isExporting' => true,
            'isExportFinished' => false,
        ]);
    }

    /**
     * Update export status.
     * 
     * @param  \Illuminate\Http\Request  $request
     */
    public function updateExportProgress(Request $request)
    {
        if ( ! $request->has('batchId') ) {
            return response()->json([
                'code' => 404,
                'msg' => 'Batch Id is required.',
            ]);
        }

        $batch = Bus::findBatch($request->input('batchId'));

        if ( $batch ) {
            return response()->json([
                'code' => 200,
                'msg' => trans('home.export.link', [
                    'href' => route('ticket.download-export', ['batchId' => $batch->id]),
                    'name' => Cache::get($batch->id),
                ]),
                'batchId' => $batch->id,
                'isExportFinished' => $batch->finished(),
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'Queue job not found!',
            ]);
        }
    }

    /**
     * Download export file
     * 
     * @param  \Illuminate\Http\Request  $request
     */
    public function downloadExport(Request $request)
    {
        $file_name = Cache::get($request->input('batchId'));
        if ( $file_name ) {
            return response()->download(Storage::path('public/' . $file_name))->deleteFileAfterSend();
        }
    }
}
