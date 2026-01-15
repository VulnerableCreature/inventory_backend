<?php

use App\Shared\AppException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ValidationException $e, Request $request): JsonResponse|null {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], $e->status ?? 422);
            }

            return null;
        });

        $exceptions->render(function (AppException $e, Request $request): JsonResponse|null {
            if ($request->expectsJson()) {
                return $e->render();
            }

            return null;
        });

        $exceptions->render(function (ThrottleRequestsException $e, Request $request): JsonResponse|null {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Too many attempts. Try again later.',
                    'status' => $e->getStatusCode()
                ], 429);
            }

            return null;
        });
    })->create();
