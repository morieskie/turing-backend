<?php

namespace Turing\Cart;

use Illuminate\Http\Resources\Json\Resource;
use Route;
use Turing\Backend\Providers\BaseRouteServiceProvider;
use Turing\Backend\Repository\RepositoryInterface;
use Turing\Cart\Http\Controllers\CartController;
use Turing\Cart\Http\Resources\CartResource;
use Turing\Cart\Repository\CartRepository;

/**
 * Class CartServiceProvider
 * @package Turing\CartResource
 */
class CartServiceProvider extends BaseRouteServiceProvider
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
        Resource::withoutWrapping();
        $this->app->when(Resource::class)
            ->needs('$resource')
            ->give(CartResource::class);

        app()->when(CartController::class)
            ->needs(RepositoryInterface::class)
            ->give(CartRepository::class);
    }
}
