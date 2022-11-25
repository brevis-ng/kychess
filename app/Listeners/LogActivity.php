<?php

namespace App\Listeners;

use App\Events\OnChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogActivity
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OnChanged  $event
     * @return void
     */
    public function handle(OnChanged $event)
    {
        DB::table('logs')->insert([
            'operator' => Auth::user()->name,
            'method' => request()->method(),
            'type' => $event->type,
            'ip' => request()->ip(),
            'description' => $event->description,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
