<?php
// kernel bootstrap file

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;
use App\Http\Middleware\JwtMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // global cors middleware
        $middleware->use([
            HandleCors::class
        ]);
        // csrf token validation except for api routes
        $middleware->validateCsrfTokens(except: [
            'api/*'
        ]);
        // jwt middleware alias - not used by default
        $middleware->alias([
            'jwt.auth.middleware' => JwtMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
