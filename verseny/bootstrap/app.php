<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CustomAuthorization;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //$middleware->append('CustomAuthorization',CustomAuthorization::class);
        $middleware->redirectGuestsTo('/');
        $middleware->validateCsrfTokens(["**"]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
