<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    
    ->withMiddleware(function (Middleware $middleware) {

        // $middlewareGroups = [
        //     'web' => [
        //         // Other middlewares...
        //         \Illuminate\Session\Middleware\StartSession::class,

        //         \App\Http\Middleware\SetLocale::class,
        //     ],
        // ];


        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,        
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();