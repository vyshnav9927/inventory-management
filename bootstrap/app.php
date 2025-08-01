<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(
            fn() => throw new HttpResponseException(
                response()->json(['message' => 'Unauthorized!'], 401)
            )
        );
    })->withEvents(discover: [
        __DIR__ . '/../app/Listeners',
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
