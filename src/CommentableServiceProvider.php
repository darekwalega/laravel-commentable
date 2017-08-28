<?php

namespace Abix\Commentable;

use Illuminate\Support\ServiceProvider;

class CommentableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([realpath(__DIR__ . '/../database/migrations') => database_path('migrations')], 'migrations');

        $this->publishes([realpath(__DIR__ . '/../config') => config_path()], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // ...
    }
}
