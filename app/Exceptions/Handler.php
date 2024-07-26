<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        $response_data = ["success" => 0, "message" => "invalid token or user session has expired!"];
        if ($request->expectsJson()) {
            return response()->json($response_data, 401);
        }
        $guards = $exception->guards();
        $guard = "";
        if ($guards) {
            $guard = $guards[0];
        }
        switch ($guard) {
            case 'admin':
                $login = 'admin.login_form';
                break;
            case 'api':
                return response()->json($response_data, 401);
                break;
            case 'web':
                $login = 'user.loginForm';
                break;
            case 'weboperator':
                $login = 'operator.login';
                break;
            default:
                $login = 'login';
                break;
        }
        return redirect()->guest(route($login));
    }


    public function render($request, Throwable $exception)
    {
        if ($this->isHttpException($exception)) {
            $statusCode = $exception->getStatusCode();
            if (view()->exists("errors.{$statusCode}")) {
                return response()->view("errors.{$statusCode}", [], $statusCode);
            }
        }
        return parent::render($request, $exception);
    }
}
