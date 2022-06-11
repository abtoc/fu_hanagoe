<?php

namespace App\Providers;

use App\Repository\YoutubeRepository;
use App\Repository\YoutubeRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class YoutubeRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            YoutubeRepositoryInterface::class,
            YoutubeRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
