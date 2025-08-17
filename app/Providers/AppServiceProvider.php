<?php

namespace App\Providers;

use App\Repositories\Interfaces\IUserRepo;
use App\Repositories\UserRepo;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->singleton(IUserRepo::class, UserRepo::class);
    }
}
