<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
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

        $this->renderable(function (\Exception $exception) {
            if ($exception instanceof NotFoundHttpException) {
                return response()->error(Response::HTTP_NOT_FOUND, 'Route not found');
            } elseif ($exception instanceof TokenExpiredException) {
                $data = [
                    'access_token' => JWTAuth::parseToken()->refresh(),
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60
                ];
                return response()->success(Response::HTTP_RESET_CONTENT, 'Token expired', $data);
            } elseif ($exception instanceof TokenInvalidException) {
                return response()->error(Response::HTTP_UNAUTHORIZED, 'Token is invalid');
            } elseif ($exception instanceof JWTException) {
                return response()->error(Response::HTTP_UNAUTHORIZED, 'Issues with Token');
            } elseif ($exception instanceof AuthorizationException) {
                return response()->error(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
            } elseif ($exception instanceof AccessDeniedHttpException) {
                return response()->error(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
            }elseif($exception instanceof UnauthorizedException){
                return response()->error(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
            }elseif($exception instanceof UnauthorizedHttpException){
                return response()->error(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
            }elseif($exception instanceof AuthenticationException){
                return response()->error(Response::HTTP_UNAUTHORIZED, 'Unauthenticated');
            }
        });
    }
}
