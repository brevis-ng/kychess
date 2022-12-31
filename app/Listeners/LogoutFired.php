<?php

namespace App\Listeners;

use App\Models\Log;
use Exception;
use Illuminate\Auth\Events\Logout as AuthLogout;

class LogoutFired
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
     * @param  AuthLogout  $event
     * @return void
     */
    public function handle(AuthLogout $event)
    {
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
                'type' => 'logout',
            ]);
        } catch (Exception $e) {}
    }
}
