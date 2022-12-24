<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
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
}
