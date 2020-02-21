<?php

namespace App\Providers;

use App\Domain\Containers\ServiceContainer;
use App\Domain\Repositories\UserRepository;
use App\Domain\Services\UserService;
use Illuminate\Support\ServiceProvider;

class ServiceContainerProvider extends ServiceProvider
{
    public function boot()
    {
        $serviceContainer = $this->app[ServiceContainer::class];

        $serviceContainer->addService(new UserService(new UserRepository($this->app)));
    }

    public function register()
    {
        $this->app->singleton(
            ServiceContainer::class,
            function () {
                return new ServiceContainer();
            }
        );
    }
}
