<?php

namespace App\Listeners;

use App\Events\OnChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login as AuthLogin;

class LoginFired
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
     * @param  AuthLogin  $event
     * @return void
     */
    public function handle(AuthLogin $event)
    {
        if ( $event->user instanceof \App\Models\User ) {
            // @brevis-ng: Update this login info
            $event->user->login_count += 1;
            $event->user->last_login = date("Y-m-d H:i:s");
            $event->user->last_login_ip = request()->ip();

            $event->user->save();

            // @brevis-ng: Dispatch the logging event
            event(new OnChanged('login', '使用IP: ' . request()->ip() . '登录。'));
        }
    }
}
