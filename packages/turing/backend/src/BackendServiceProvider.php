<?php

namespace Turing\Backend;

use Turing\Backend\Exceptions\Handler;
use Turing\Backend\Providers\BaseRouteServiceProvider;

/**
 * Class BackendServiceProvider
 * @package Turing\Backend
 */
class BackendServiceProvider extends BaseRouteServiceProvider
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
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
        //$this->app->singleton(\Illuminate\Validation\ValidationException::class, \Turing\Backend\Exceptions\FailedHttValidationException::class);
        $this->app->singleton(\Illuminate\Contracts\Debug\ExceptionHandler::class, \Turing\Backend\Exceptions\Handler::class);
    }
}
