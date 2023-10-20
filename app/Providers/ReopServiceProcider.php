<?php

namespace App\Providers;

use App\Interfaces\ClientOrderInterface;
use App\Repository\ClientOrderRepo;
use Illuminate\Support\ServiceProvider;

class ReopServiceProcider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ClientOrderInterface::class, ClientOrderRepo::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
