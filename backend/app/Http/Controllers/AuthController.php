<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller {
  private AuthService $authService;

  public function __construct(AuthService $authService) {
    $this->authService = $authService;
  }

  /**
    * Register a new user
    */
  public function register(RegisterRequest $request): JsonResponse {
    $result = $this->authService->register($request->validated());
    
    return response()->json($result, 201);
  }

  /**
    * Login user and return JWT token
    */
  public function login(LoginRequest $request): JsonResponse {
    $result = $this->authService->login($request->validated());

    if (!$result["success"]) {
      return response()->json($result,401);
    }

    return response()->json($result);
  }
}