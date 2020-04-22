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
        $this->publishes([
            __DIR__ . '/../config/enum.php' => resource_path('lang/en/enum.php'),
        ]);
    }
}
