<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Config;
use App\Models\Role;
use App\Models\Ticket;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
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
        $data = [];
        $data['all'] = Ticket::all()->count();
        $data['all_accepted'] = Ticket::where('status', Ticket::ACCEPTED)->count();
        $data['all_rejected'] = Ticket::where('status', Ticket::REJECTED)->count();
        $data['all_bonus'] = Ticket::where('status', Ticket::ACCEPTED)->sum('bonus');

        $period = new DatePeriod(new DateTime(date('Y-m-d', strtotime('-1 week'))), new DateInterval('P1D'), new DateTime(date('Y-m-d')));
        $days_of_week = [];
        foreach ($period as $key => $value) {
            $days_of_week[] = $value->format('Y-m-d');
        }
        $data['days_of_week'] = $days_of_week;

        $activities = Activity::where('active', true)
            ->withCount([
                "tickets as tickets_0_count" => function (Builder $query) use($days_of_week) {
                    $query->whereDate('created_at', $days_of_week[0]);
                },
                "tickets as tickets_1_count" => function (Builder $query) use($days_of_week) {
                    $query->whereDate('created_at', $days_of_week[1]);
                },
                "tickets as tickets_2_count" => function (Builder $query) use($days_of_week) {
                    $query->whereDate('created_at', $days_of_week[2]);
                },
                "tickets as tickets_3_count" => function (Builder $query) use($days_of_week) {
                    $query->whereDate('created_at', $days_of_week[3]);
                },
                "tickets as tickets_4_count" => function (Builder $query) use($days_of_week) {
                    $query->whereDate('created_at', $days_of_week[4]);
                },
                "tickets as tickets_5_count" => function (Builder $query) use($days_of_week) {
                    $query->whereDate('created_at', $days_of_week[5]);
                },
                "tickets as tickets_6_count" => function (Builder $query) use($days_of_week) {
                    $query->whereDate('created_at', $days_of_week[6]);
                },
            ])
            ->orderBy('id', 'DESC')
            ->get();

        foreach ($activities as $key => $value) {
            $data['legend'][] = $value->title;
            $data['activity'][$key]['name'] = $value->title;
            $data['activity'][$key]['stack'] = '总量';
            $data['activity'][$key]['areaStyle'] = [];
            $data['activity'][$key]['type'] = 'line';
            $data['activity'][$key]['data'] = [$value->tickets_0_count, $value->tickets_1_count, $value->tickets_2_count, $value->tickets_3_count, $value->tickets_4_count, $value->tickets_5_count, $value->tickets_6_count];
        }
        // dd($data);

        return view('admin.dashboard', [
            'data' => $data,
        ]);
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
