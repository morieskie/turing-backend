<?php

namespace Turing\Backend\Providers\Providers;

use Tymon\JWTAuth\Http\Parser\AuthHeaders;
use Tymon\JWTAuth\Http\Parser\Cookies;
use Tymon\JWTAuth\Http\Parser\InputSource;
use Tymon\JWTAuth\Http\Parser\Parser;
use Tymon\JWTAuth\Http\Parser\QueryString;
use Tymon\JWTAuth\Http\Parser\RouteParams;
use Tymon\JWTAuth\JWTGuard;
use Tymon\JWTAuth\Providers\LaravelServiceProvider;

class ApiTokenServiceProvider extends LaravelServiceProvider
{

    /**
     * Register the bindings for the Token Parser.
     *
     * @return void
     */
    protected function registerTokenParser()
    {
        $this->app->singleton('tymon.jwt.parser', function ($app) {
            $authHeader = new AuthHeaders;
            $authHeader->setHeaderName('USER-KEY');
            $parser = new Parser(
                $app['request'],
                [
                    $authHeader,
                    new QueryString,
                    new InputSource,
                    new RouteParams,
                    new Cookies($this->config('decrypt_cookies')),
                ]
            );

            $app->refresh('request', $parser, 'setRequest');

            return $parser;
        });
    }
}
