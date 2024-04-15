<?php

namespace App\Providers;

use App\Interfaces\InventoryInterface;
use App\Interfaces\ItemInterface;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
