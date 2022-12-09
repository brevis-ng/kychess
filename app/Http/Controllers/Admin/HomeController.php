<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * Dashboard
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * Menu
     * 
     * @return \Illuminate\Http\Response
     */
    public function menu()
    {
        $role = Role::find(Auth::user()->role_id);
        if ( $role ) {
            return $role->menu;
        } else {
            $dummy = [
                'homeInfo' => ['title' => '首页', 'href' => route('home.dashboard')],
                'logoInfo' => ['title' => '后台', 'image' => '/layuimini/images/logo.png'],
                'menuInfo' => [],
            ];
            return json_encode($dummy);
        }
    }

    /**
     * System log event
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function log(Request $request)
    {
        
    }

    /**
     * IP whitelist settings
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function whitelist(Request $request)
    {
        
    }

    /**
     * An announcement displayed in activity page
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function announcement(Request $request)
    {
        
    }

    /**
     * Upload activity poster
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload_poster(Request $request)
    {
        if ( ! $request->has('picture') ) {
            return response()->json([
                'code' => 422,
                'msg' => trans('validation.file', ['attribute' => trans('home.activity.poster')]),
            ]);
        }

        $validated = $request->validate([
            'picture' => ['file', 'mimetypes:image/jpeg,image/x-png,image/png,image/gif,image/bmp'],
        ]);

        $path = $request->file('picture')->store('activity');

        if ( $path !== false ) {
            Cache::forever('newest_poster_path', $path);
            return response()->json([
                'code' => 0,
                'msg' => 'OK',
                'path' => $path,
            ]);
        } else {
            return response()->json(['code' => 422, 'msg' => 'Upload failed']);
        }
    }

    /**
     * Delete uploaded poster if user cancel creating process
     * 
     * @return \Illuminate\Http\Response
     */
    public function cancel_upload()
    {
        if ( Cache::has('newest_poster_path') ) {
            Storage::delete(Cache::get('newest_poster_path'));

            return response()->json([
                'code' => 200,
                'msg' => trans('home.activity.poster') . ' ' . trans('home.delete.ok'),
            ]);
        }

        return response()->json([
            'code' => 404,
            'msg' => 'Dont need',
        ]);
    }
}
