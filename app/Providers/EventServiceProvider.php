<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\OnMenuChanged;
use App\Listeners\LoginFired;
use App\Listeners\LogoutFired;
use App\Listeners\MenuFired;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Login::class => [
            LoginFired::class,
        ],
        Logout::class => [
            LogoutFired::class,
        ],
        OnMenuChanged::class => [
            MenuFired::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
