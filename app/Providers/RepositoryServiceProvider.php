<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //数据操作仓库
        $this->app->bind(
            //'App\Repository\Interfaces\TestInterface',
            //'App\Repository\Repositories\TestRepository'
        );
    }
}
