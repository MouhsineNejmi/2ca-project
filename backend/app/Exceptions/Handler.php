<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
  /**
   * A list of exception types with custom log levels.
   *
   * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
   */
  protected $levels = [];

  /**
   * A list of the exception types that are not reported.
   *
   * @var array<int, class-string<\Throwable>>
   */
  protected $dontReport = [];

  /**
   * A list of the inputs that are never flashed to the session on validation exceptions.
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
  protected function unauthenticated($request, AuthenticationException $exception)
  {
    return response()->json(['message' => 'Unauthenticated'], 401);
  }
}