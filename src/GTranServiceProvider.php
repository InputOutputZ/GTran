<?php

namespace GTran\Translate;

use Illuminate\Support\ServiceProvider;

class GTranServiceProvider extends ServiceProvider
{

    protected $defer = false;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__.'/config/gtran.php' => config_path('gtran.php')]);
        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/gtran.php', 'gtran'
        );

        $this->app->singleton('gtran', function ($app) {
            return new GTran(
                $app['config']['gtran.key'],
                $app['config']['gtran.host'],
                $app['config']['gtran.detectpath'],
                $app['config']['gtran.transpath'],
                $app['config']['gtran.languagepath']
            );
        });

        $this->app->make('\GTran\Translate\PlayWithAPIController');
    }

    public function provides()
    {
        return ['gtran'];
    }
}
