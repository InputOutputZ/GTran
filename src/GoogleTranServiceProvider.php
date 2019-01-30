<?php

namespace GoogleTran\Translate;

use Illuminate\Support\ServiceProvider;

class GoogleTranServiceProvider extends ServiceProvider
{

    protected $defer = false;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__.'/config/googletran.php' => config_path('googletran.php')]);
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
            __DIR__.'/config/googletran.php', 'googletranslate'
        );

        $this->app->singleton('googletranslate', function ($app) {
            return new GoogleTran(
                $app['config']['googletran.key'],
                $app['config']['googletran.host'],
                $app['config']['googletran.detectpath'],
                $app['config']['googletran.languagepath']
            );
        });

        $this->app->make('\GoogleTran\Translate\PlayWithAPIController');
    }

    public function provides()
    {
        return ['googletranslate'];
    }
}
