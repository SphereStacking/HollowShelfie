<?php

namespace App\Exceptions;

use Throwable;
use Inertia\Inertia;
use Sentry\Laravel\Integration;
use Laravel\Socialite\Two\InvalidStateException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Http\Middleware\HandleInertiaRequests;
class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (InvalidStateException $e, $request) {
            return Inertia::render('Errors/InvalidState', [
                'message' => $e->getMessage(),
            ]);
        });

        $this->renderable(function (EventNotPublishedException $e, $request) {
            return Inertia::render('Errors/404Error', [
                'message' => $e->getMessage(),
            ]);
        });

        $this->renderable(function (CannotOperateEventException $e, $request) {
            return Inertia::render('Errors/403Error', [
                'message' => $e->getMessage(),
            ]);
        });

        // abortで発火したエラーはこちらに入る。
        $this->renderable(function (HttpException $e, $request) {
            $statusCode = $e->getStatusCode();
            $message = $e->getMessage();
            return match ($statusCode) {
                403 => function () use ($request, $message) {
                    Inertia::share((new HandleInertiaRequests)->share($request));
                    return Inertia::render('Errors/403Error', ['message' => $message]);
                },
                404 => Inertia::render('Errors/404Error', ['message' => $message]),
                418 => Inertia::render('Errors/418Error', ['message' => $message]),
                429 => Inertia::render('Errors/429Error', ['message' => $message]),
                500 => Inertia::render('Errors/500Error', ['message' => $message]),
                503 => Inertia::render('Errors/503Error', ['message' => $message]),
                default => function() use ($e, $message) {
                    Integration::captureUnhandledException($e);
                    return Inertia::render('Errors/500Error', ['message' => $message]);
                },
            };
        });


        $this->reportable(function (Throwable $e) {
            Integration::captureUnhandledException($e);
        });
    }
}
