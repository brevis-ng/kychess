<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
