<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    /**
     * IP whitelist
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function whitelist(Request $request)
    {
        if ( $request->isMethod('PUT') ) {
            $validated = $request->validate([
                'whitelist' => 'required'
            ]);

            $validated['whitelist'] = preg_replace("/[^\d\.\,]/", "", $validated['whitelist']);

            $validated['whitelist'] = trim($validated['whitelist'], ",");

            $count = Config::where('meta_key', 'ip_whitelist')->first()->update(['meta_value' => $validated['whitelist']]);
            
            if ( $count ) {
                return response()->json(['code' => 200, 'msg' => trans('home.edit.ok')]);
            } else {
                return response()->json(['code' => 400, 'msg' => trans('home.edit.no')]);
            }
        }
        $config = Config::where('meta_key', 'ip_whitelist')->first();
        return view('admin.system.whitelist', ['whitelist' => $config->meta_value]);
    }

    /**
     * Announcement
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function announcement(Request $request)
    {
        if ( $request->isMethod('PUT') ) {
            $validated = $request->validate([
                'announcement' => 'required'
            ]);

            $validated['announcement'] = trim($validated['announcement']);

            $count = Config::where('meta_key', 'announcement')->first()->update(['meta_value' => $validated['announcement']]);
            
            if ( $count ) {
                return response()->json(['code' => 200, 'msg' => trans('home.edit.ok')]);
            } else {
                return response()->json(['code' => 400, 'msg' => trans('home.edit.no')]);
            }
        }
        $config = Config::where('meta_key', 'announcement')->first();
        return view('admin.system.announcement', ['announcement' => $config->meta_value]);
    }

    /**
     * Operating Log
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function log(Request $request)
    {
        if ( $request->has("type") && hash_equals("menu", $request->query("type")) ) {
            $current_page = $request->filled("page") ? intval($request->input("page")) : 1;
            $per_page = $request->filled("limit") ? intval($request->input("limit")) : 20;

            $where = [];
            if ($request->filled("searchParams")) {
                $params = json_decode($request->input("searchParams"), true);

                if ($params["user_id"] != "") {
                    $where[] = ["user_id", $params["user_id"]];
                }
                if ($params["dateFrom"] != "") {
                    $where[] = ["created_at", ">=", $params["dateFrom"]];
                }
                if ($params["dateTo"] != "") {
                    $where[] = ["created_at", "<=", $params["dateTo"]];
                }
            }
            
            $tickets = Log::where($where)
                ->with(['user'])
                ->orderBy("id", "desc")
                ->paginate($per_page, ["*"], "page", $current_page)
                ->toArray();

            return response()->json([
                "code" => 0,
                "msg" => "success",
                "count" => $tickets["total"],
                "data" => $tickets["data"],
            ]);
        }

        return view('admin.system.log', [
            'users' => User::all(),
        ]);
    }

    public function show_log(Request $request, $id)
    {
        $log = Log::find($id);
        return view('admin.system.show_log', [
            'log' => $log,
        ]);
    }
}
