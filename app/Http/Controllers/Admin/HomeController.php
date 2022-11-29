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
        $role = Role::find(Auth::user()->id);
        if ( $role ) {
            // $menu = $role->menu['menuInfo'];
            // foreach ( $menu[0]['child'] as $key => $child ) {
            //     $role->menu['menuInfo'][0]['child'][$key]['title'] = trans('home.' . $role->menu['menuInfo'][0]['child'][$key]['title']);
            // }
            // dd($role->menu);

            return $role->menu;
        }
    }
}
