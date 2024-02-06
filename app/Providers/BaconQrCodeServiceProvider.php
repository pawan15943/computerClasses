<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\Image\Png;



class BaconQrCodeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton('bacon.qrcode', function ($app) {
            $renderer = new Png();
            $renderer->setHeight(300);
            $renderer->setWidth(300);

            return new Writer($renderer);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
