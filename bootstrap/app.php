<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
        $exceptions->render(function (\Throwable $e, Request $request) {
            echo "<h1>Original Boot Exception: " . htmlspecialchars($e->getMessage()) . "</h1>";
            echo "<p><b>" . htmlspecialchars($e->getFile()) . "</b> on line " . $e->getLine() . "</p>";
            echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
            exit;
        });
    })->create();

if (getenv('VERCEL') || isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || is_dir('/tmp/storage')) {
    $app->useStoragePath('/tmp/storage');
}

return $app;
