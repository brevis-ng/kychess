<?php

namespace App\Listeners;

use App\Models\Log;
use Exception;
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
        // if ( $event->user instanceof \App\Models\User ) {
        //     // @brevis-ng: Update this login info
        //     $event->user->login_count += 1;
        //     $event->user->last_login = date("Y-m-d H:i:s");
        //     $event->user->last_ip = request()->ip();

        //     $event->user->save();

        //     // @brevis-ng: Dispatch the logging event
        //     event(new OnChanged('login', '使用IP: ' . request()->ip() . '登录。'));
        // }
        $user = $event->user;
            
        // $instance = app(config('ladmin.user'));
        // if(! ($user instanceof $instance)) {
        //     return;
        // }

        // if(is_null($user->role_id)) {
        //     return;
        // }

        try {

            $new_data = [
                'ip' => $_SERVER['REMOTE_ADDR'],
                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            ];
            
            Log::create([
                'user_id' => $user->id,
                'new_data' => $new_data,
                'logable_type' => get_class($user),
                'logable_id' => $user->id,
                'old_data' => [],
                'type' => 'login',
            ]);
        } catch (Exception $e) {}
    }
}
