<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        Livewire::setUpdateRoute(function ($handle) {
            return \Illuminate\Support\Facades\Route::post(
                '/livewire/update',
                $handle
            )->middleware('web');
        });
    }
}