<?php

namespace App\Exceptions;

use Throwable;
use Inertia\Inertia;
use Laravel\Socialite\Two\InvalidStateException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
            return Inertia::render('Errors/InvalidState', []);
        });

        $this->renderable(function (EventNotPublishedException $e, $request) {
            return Inertia::render('Errors/EventNotPublished', []);
        });
    }
}
