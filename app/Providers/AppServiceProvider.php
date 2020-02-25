<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Inertia::share([
            'app' => [
                'name' => Config::get('app.name')
            ],
            'auth' => function () {
                return [
                    'user' => $user = Auth::user() ? [
                        'id' => Auth::user()->id,
                        'name' => Auth::user()->name,
                    ] : null
                ];
            },
            'errors' => function () {
                return Session::get('errors')
                    ? Session::get('errors')->getBag('default')->getMessages()
                    : (object) [];
            },
            'status' => function () {
                return session('status', null);
            },
            'pops' => function () {
                return session('pops', null);
            },
        ]);
    }
}
