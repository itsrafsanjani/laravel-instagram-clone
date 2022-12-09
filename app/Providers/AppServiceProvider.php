<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

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
        Paginator::useBootstrap();

        Model::preventLazyLoading(
            ! app()->isProduction()
        );

        Model::preventSilentlyDiscardingAttributes(
            ! app()->isProduction()
        );

        LogViewer::auth(function ($request) {
            return $request->user()
                && $request->user()->is_admin;
        });
    }
}
