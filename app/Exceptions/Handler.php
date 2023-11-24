<?php

namespace App\Exceptions;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

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
        $this->renderable(function (Throwable $e) {
//            dd($e);
            switch ($e) {
                case $e instanceof AuthenticationException:
                    return Controller::getJsonResponse('Unauthenticated', null, false, 401);
                case $e instanceof UnauthorizedException
                    || $e instanceof AccessDeniedHttpException
                    || $e instanceof \Spatie\Permission\Exceptions\UnauthorizedException:
                    return Controller::getJsonResponse('Unauthorized', null, false, 403);
                case $e instanceof RecordsNotFoundException:
                    return Controller::getJsonResponse('Requested resource not found', null, false, 404);
                case $e instanceof RouteNotFoundException
                    || $e instanceof NotFoundHttpException:
                    return Controller::getJsonResponse('Requested resource was not found', null, false, 404);
                /* Validations Exceptions */
                case $e instanceof ValidationException:
                    return Controller::getJsonResponse('Invalid data', $e->errors(), false, 422);
//                    /* Other Exceptions */
                default:
                    return Controller::getJsonResponse('Internal Serve error', null, false, 500, $e);


            }
        });
    }
}
