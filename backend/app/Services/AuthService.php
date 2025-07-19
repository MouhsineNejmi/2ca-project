<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Log;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Authentication service handling user registration, login
 * 
 */
class AuthService
{
  private UserRepository $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  /**
   * Register a new user
   */
  public function register(array $data): array
  {
    $data['password'] = Hash::make($data['password']);

    $user = $this->userRepository->create($data);

    $token = JWTAuth::fromUser($user);
    
    return [
      'success' => true,
      'message' => "Register success!",
      'user' => $user,
      'token' => $token,
    ];
  }

  /**
   * Login user and return JWT token
   */
  public function login(array $credentials): array
  {
    if (!$token = JWTAuth::attempt($credentials)) {
      return [
        'success' => false,
        'message' => 'Invalid credentials'
      ];
    }

    return [
      'success' => true,
      'user' => auth()->user(),
      'token' => $token,
    ];
  }

  /**
   * Logout user by invalidating token
   */
  public function logout(): void
  {
    JWTAuth::invalidate(JWTAuth::getToken());
  }
}