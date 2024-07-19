<?php

namespace Modules\messenger\app\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($request->is('api/messenger-*')) {
            $status = Response::HTTP_BAD_REQUEST;
            $error = 'HTTP_BAD_REQUEST';
            $message = $e->getMessage();
            $trace = (config('app.env') != 'production') ? $e->getTrace() : null;

            if($e instanceof NotFoundHttpException) {
                $status = Response::HTTP_NOT_FOUND;
                $error = 'HTTP_NOT_FOUND';
            }

            if($e instanceof ValidationException) {
                $status = Response::HTTP_UNPROCESSABLE_ENTITY;
                $error = 'HTTP_UNPROCESSABLE_ENTITY';
                $message = $e->errors();
            }

            if($e instanceof AuthenticationException) {
                $status = Response::HTTP_UNAUTHORIZED;
                $error = 'HTTP_UNAUTHORIZED';
                $message = $e->errors();
            }

            if($e instanceof AuthorizationException) {
                $status = Response::HTTP_UNAUTHORIZED;
                $error = 'HTTP_UNAUTHORIZED';
                $message = $e->errors();
            }

            return response()->messengerJsonError(
                error: $error,
                message: $message,
                status: $status,
                trace: $trace,
            );
        }

        return parent::render($request, $e);
    }

    public function report(Throwable $e)
    {
//        if($e instanceof NotFoundHttpException) {
//            Log::info('NotFoundHttpException: '.$e->getMessage());
//        }

        parent::report($e);
    }

}
