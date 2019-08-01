<?php

namespace Turing\Tax;

use Illuminate\Http\Resources\Json\Resource;
use Route;
use Turing\Backend\Providers\BaseRouteServiceProvider;
use Turing\Backend\Repository\RepositoryInterface;
use Turing\Tax\Http\Controlllers\TaxController;
use Turing\Tax\Http\Resources\TaxResource;
use Turing\Tax\Repository\TaxRepository;

/**
 * Class TaxServiceProvider
 * @package Turing\TaxResource
 */
class TaxServiceProvider extends BaseRouteServiceProvider
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
            ->give(TaxResource::class);

        $this->app->when(TaxController::class)
            ->needs(RepositoryInterface::class)
            ->give(TaxRepository::class);
    }
}
