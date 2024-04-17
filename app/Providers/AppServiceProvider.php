<?php

namespace App\Providers;

use App\Interfaces\EmployeeInterface;
use App\Interfaces\InventoryInterface;
use App\Interfaces\ItemInterface;
use App\Services\EmployeeService;
use App\Services\InventoryService;
use App\Services\ItemService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ItemInterface::class, ItemService::class);
        $this->app->bind(InventoryInterface::class, InventoryService::class);
        $this->app->bind(EmployeeInterface::class, EmployeeService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
