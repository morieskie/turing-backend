<?php

namespace Turing\Shipping;

use Illuminate\Http\Resources\Json\Resource;
use Route;
use Turing\Backend\Providers\BaseRouteServiceProvider;
use Turing\Backend\Repository\RepositoryInterface;
use Turing\Shipping\Http\Controlllers\ShippingController;
use Turing\Shipping\Http\Resources\ShippingResource;
use Turing\Shipping\Repository\ShippingRepository;

/**
 * Class ShippingServiceProvider
 * @package Turing\Shipping
 */
class ShippingServiceProvider extends BaseRouteServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = __NAMESPACE__ . '\Http\Controllers';

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/routes/api.php');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Resource::withoutWrapping();
        $this->app->when(Resource::class)
            ->needs('$resource')
            ->give(ShippingResource::class);

        $this->app->when(ShippingController::class)
            ->needs(RepositoryInterface::class)
            ->give(ShippingRepository::class);
    }
}
