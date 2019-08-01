<?php

namespace Turing\Payment;

use Illuminate\Http\Resources\Json\Resource;
use Route;
use Turing\Backend\Providers\BaseRouteServiceProvider;
use Turing\Backend\Repository\RepositoryInterface;
use Turing\Payment\Http\Controllers\StripeController;
use Turing\Payment\Http\Resources\StripeResource;
use Turing\Payment\Repository\StripeRepository;

/**
 * Class PaymentServiceProvider
 * @package Turing\Payment
 */
class PaymentServiceProvider extends BaseRouteServiceProvider
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
        $this->app->when(StripeResource::class)
            ->needs('$resource')
            ->give(StripeResource::class);

        app()->when(StripeController::class)
            ->needs(RepositoryInterface::class)
            ->give(StripeRepository::class);
    }
}
