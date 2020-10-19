<?php

namespace DavidIanBonner\Enumerated;

use Illuminate\Support\ServiceProvider;

class EnumeratedServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        include_once __DIR__ . 'helpers.php';

        $this->publishes([
            __DIR__ . '/../lang/enum.php' => resource_path('lang/en/enum.php'),
        ]);
    }
}
