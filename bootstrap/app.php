<?php

use App\Http\Middleware\TestMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        # Add your global middleware here. These middleware will run during every request to your application.
        // $middleware->append(TestMiddleware::class);

        # You can also assign an alias to your middleware, which can be used in route definitions.
        $middleware->alias([
            'test' => TestMiddleware::class,
        ]);

        // This directs unauthenticated users to the root path
        // $middleware->redirectGuestsTo('/');

        // If you want to change where users go AFTER they log in:
        // $middleware->redirectUsersTo('/dashboard');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
