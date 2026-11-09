<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Http::macro('api', function () {
            return Http::baseUrl(config('services.magyarnevek.base_url'))
                ->withHeaders([
                    'x-client-id' => config('services.magyarnevek.client_id'),
                    'x-api-key'   => config('services.magyarnevek.api_key'),
                ])
                ->acceptJson()
                ->timeout(10);
        });
    }
}
