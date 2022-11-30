<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        // exception untuk findOrFail eloquent
        if ($request->header('ajax') == "1" || $request->expectsJson() || $request->ajax() || $request->header('Content-Type') == 'application/json') {
            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'code' => '404',
                    'message' => 'Record not found.',
                ]);
            }
        }

        return parent::render($request, $e);
    }

    protected function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception)
    {
        $login = route('auth.login.get');

        return $request->expectsJson()
            ? response()->json([
                'message' => $exception->getMessage(),
                'auth_url' => $login,
                'staus'    => false
            ], 401)
            : redirect()->guest($login);
    }
}
