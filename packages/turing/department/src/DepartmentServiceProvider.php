<?php

namespace Turing\Department;

use Illuminate\Http\Resources\Json\Resource;
use Route;
use Turing\Backend\Providers\BaseRouteServiceProvider;
use Turing\Backend\Repository\RepositoryInterface;
use Turing\Department\Http\Controlllers\DepartmentController;
use Turing\Department\Http\Resources\DepartmentResource;
use Turing\Department\Repository\DepartmentRepository;

/**
 * Class DepartmentServiceProvider
 * @package Turing\Department
 */
class DepartmentServiceProvider extends BaseRouteServiceProvider
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
            ->give(DepartmentResource::class);

        $this->app->when(DepartmentController::class)
            ->needs(RepositoryInterface::class)
            ->give(DepartmentRepository::class);
    }
}
